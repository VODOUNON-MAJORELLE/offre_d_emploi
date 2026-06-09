<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\OptionReponse;
use App\Models\Reponse;
use App\Models\Candidature;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    /**
     * Show create questionnaire form.
     */
    public function create($id_offre)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);

        return view('entreprise.questionnaires.create', compact('offre'));
    }

    /**
     * Store new questionnaire with questions and options.
     */
    public function store(Request $request, $id_offre)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);

        $request->validate([
            'titre_questionnaire' => 'required|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.enonce' => 'required|string',
            'questions.*.type' => 'required|in:QCM,reponse_courte',
            'questions.*.points' => 'required|integer|min:0',
            'questions.*.options' => 'array', // required only for QCM
            'questions.*.options.*.contenu' => 'string',
            'questions.*.options.*.correct' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
            // Delete existing questionnaire if any
            if ($offre->questionnaire) {
                $offre->questionnaire->delete();
            }

            $questionnaire = Questionnaire::create([
                'id_offre' => $offre->id_offre,
                'titre_questionnaire' => $request->input('titre_questionnaire'),
            ]);

            foreach ($request->input('questions') as $index => $qData) {
                $question = Question::create([
                    'id_questionnaire' => $questionnaire->id_questionnaire,
                    'enonce_question' => $qData['enonce'],
                    'type_question' => $qData['type'],
                    'points_question' => (int) $qData['points'],
                ]);

                if ($qData['type'] === 'QCM' && isset($qData['options'])) {
                    foreach ($qData['options'] as $optIndex => $oData) {
                        OptionReponse::create([
                            'id_question' => $question->id_question,
                            'contenu_option' => $oData['contenu'],
                            'est_bonne_reponse' => isset($oData['correct']) ? (bool) $oData['correct'] : false,
                            'ordre_option' => $optIndex + 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('entreprise.offres.show', $offre->id_offre)
                ->with('success', 'Questionnaire créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de la création du questionnaire : ' . $e->getMessage()]);
        }
    }

    /**
     * Grade a candidate's short answer response manually.
     */
    public function gradeShortAnswer(Request $request, $id_reponse)
    {
        $entreprise = Auth::guard('entreprise')->user();
        
        $reponse = Reponse::with('question.questionnaire.offre', 'candidature')->findOrFail($id_reponse);
        $candidature = $reponse->candidature;
        $offre = $reponse->question->questionnaire->offre;

        // Verify ownership
        if ($offre->id_entreprise !== $entreprise->id_entreprise) {
            abort(403);
        }

        $request->validate([
            'score_manuel' => 'required|integer|min:0|max:' . $reponse->question->points_question,
        ]);

        DB::transaction(function () use ($reponse, $candidature, $request) {
            $scoreManuel = (int) $request->input('score_manuel');
            
            $reponse->update([
                'score_manuel' => $scoreManuel,
                'score_reponse' => $scoreManuel,
                'est_correcte' => $scoreManuel > 0, // partially correct if > 0
            ]);

            // Recalculate questionnaire score
            $allReponses = Reponse::where('id_candidature', $candidature->id_candidature)->get();
            $questions = Question::where('id_questionnaire', $candidature->offre->questionnaire->id_questionnaire)->get();

            $totalPoints = $questions->sum('points_question');
            $earnedPoints = $allReponses->sum('score_reponse');

            $scoreQuestionnaireNorm = 0;
            if ($totalPoints > 0) {
                $scoreQuestionnaireNorm = ($earnedPoints / $totalPoints) * 100;
            }

            $candidature->score_questionnaire = (int) round($scoreQuestionnaireNorm);

            // Fetch compatibility score from scores table
            $compatScore = Score::where('id_candidat', $candidature->id_candidat)
                ->where('id_offre', $candidature->id_offre)
                ->value('score_compatibilite') ?? $candidature->score_final; // fallback

            // Combine final score: 60% compatibility + 40% questionnaire
            $candidature->score_final = (int) round(($compatScore * 0.6) + ($scoreQuestionnaireNorm * 0.4));
            $candidature->save();

            // Send notification to Candidate that their questionnaire has been graded
            $existingNotification = DB::table('notifications')
                ->where('id_candidat', $candidature->id_candidat)
                ->whereNull('id_entreprise')
                ->where('type_notification', 'statut')
                ->where('statut_lecture', 'non lu')
                ->first();

            if ($existingNotification) {
                // Update existing notification
                DB::table('notifications')
                    ->where('id_notification', $existingNotification->id_notification)
                    ->update([
                        'titre_notification' => 'Questionnaire corrigé',
                        'contenu_notification' => 'Le recruteur a évalué vos réponses au questionnaire pour le poste : ' . $candidature->offre->titre_offre,
                        'id_reference' => $candidature->id_candidature,
                        'date_envoi' => now(),
                        'updated_at' => now(),
                    ]);
            } else {
                // Create new notification
                DB::table('notifications')->insert([
                    'id_candidat' => $candidature->id_candidat,
                    'titre_notification' => 'Questionnaire corrigé',
                    'contenu_notification' => 'Le recruteur a évalué vos réponses au questionnaire pour le poste : ' . $candidature->offre->titre_offre,
                    'type_notification' => 'statut',
                    'id_reference' => $candidature->id_candidature,
                    'type_reference' => 'candidature',
                    'date_envoi' => now(),
                    'statut_lecture' => 'non lu',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->back()->with('success', 'Note attribuée avec succès.');
    }
}
