<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Cv;
use App\Models\Candidature;
use App\Models\Reponse;
use App\Models\Question;
use App\Models\OptionReponse;
use App\Models\Score;
use App\Models\ProgressionCandidature;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as FacadeResponse;

class CandidatureController extends Controller
{
    protected MatchingService $matchingService;

    public function __construct(MatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    /**
     * Display the post form.
     */
    public function showApplyForm($id_offre)
    {
        $offre = Offre::with('questionnaire.questions.options')->findOrFail($id_offre);
        $candidat = Auth::guard('candidat')->user();
        
        // Check if candidate has already applied
        $existingCandidature = Candidature::where('id_candidat', $candidat->id_candidat)
            ->where('id_offre', $id_offre)
            ->first();
        
        if ($existingCandidature && !request()->has('edit')) {
            // Calculate and store compatibility score
            $matchResult = $this->matchingService->calculateScore($candidat, $offre);
            
            Score::updateOrCreate(
                ['id_candidat' => $candidat->id_candidat, 'id_offre' => $offre->id_offre],
                [
                    'score_competences' => $matchResult['score_competences'],
                    'score_experience' => $matchResult['score_experience'],
                    'score_etudes' => $matchResult['score_etudes'],
                    'score_localisation' => $matchResult['score_localisation'],
                    'score_compatibilite' => $matchResult['score_compatibilite'],
                    'date_calcul' => now(),
                ]
            );
            
            return view('candidat.already-applied', compact('offre', 'existingCandidature', 'matchResult'));
        }
        
        // Calculate and store compatibility score when viewing the offer
        $matchResult = $this->matchingService->calculateScore($candidat, $offre);
        
        Score::updateOrCreate(
            ['id_candidat' => $candidat->id_candidat, 'id_offre' => $offre->id_offre],
            [
                'score_competences' => $matchResult['score_competences'],
                'score_experience' => $matchResult['score_experience'],
                'score_etudes' => $matchResult['score_etudes'],
                'score_localisation' => $matchResult['score_localisation'],
                'score_compatibilite' => $matchResult['score_compatibilite'],
                'date_calcul' => now(),
            ]
        );
        
        // Fetch candidate's CVs
        $cvs = Cv::where('id_candidat', $candidat->id_candidat)
            ->where('statut', 'actif')
            ->get();

        return view('candidat.postuler', compact('offre', 'cvs', 'existingCandidature'));
    }

    /**
     * Submit candidature.
     */
    public function store(Request $request, $id_offre)
    {
        $offre = Offre::with('questionnaire.questions.options')->findOrFail($id_offre);
        $candidat = Auth::guard('candidat')->user();

        // 1. Check duplicate / edit mode
        $existing = Candidature::where('id_candidat', $candidat->id_candidat)
            ->where('id_offre', $id_offre)
            ->first();

        // 2. Validate inputs - simplified form
        $rules = [
            'cv_file' => ($existing ? 'nullable' : 'required') . '|file|mimes:pdf,docx|max:5120', // 5MB
            'lettre_text' => 'nullable|string|max:2000',
        ];

        // Validate questionnaire if attached
        if ($offre->questionnaire) {
            foreach ($offre->questionnaire->questions as $question) {
                if ($question->type_question === 'QCM') {
                    $rules['answers.' . $question->id_question] = 'required|array|min:1';
                } else {
                    $rules['answers.' . $question->id_question] = 'required|string|min:1';
                }
            }
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {
            // 3. Process CV
            if ($request->hasFile('cv_file')) {
                $file = $request->file('cv_file');

                // Explicit 5 MB size guard (independent of PHP upload_max_filesize)
                if ($file->getSize() > 5 * 1024 * 1024) {
                    return redirect()->back()
                        ->withErrors(['cv_file' => 'Le fichier CV ne doit pas dépasser 5 MB. Fichier reçu : ' . round($file->getSize() / 1024 / 1024, 2) . ' MB.'])
                        ->withInput();
                }

                $binaryContent = file_get_contents($file->getRealPath());

                // Mark other CVs as not principal if needed
                Cv::where('id_candidat', $candidat->id_candidat)->update(['est_principal' => false]);

                $cv = Cv::create([
                    'id_candidat' => $candidat->id_candidat,
                    'nom_fichier' => $file->getClientOriginalName(),
                    'contenu_fichier' => $binaryContent,
                    'type_mime' => $file->getMimeType(),
                    'taille_fichier' => $file->getSize(),
                    'est_principal' => true,
                    'statut' => 'actif',
                ]);
                $id_cv = $cv->id_cv;
            } else {
                $id_cv = $existing ? $existing->id_cv : null;
            }

            // 4. Process Cover Letter (text from form)
            $lettre_motivation = $request->input('lettre_text', '');
            $nom_lettre = 'Lettre_Motivation_' . $candidat->nom . '_' . now()->format('Y-m-d') . '.txt';
            $type_mime_lettre = 'text/plain';
            $taille_lettre = strlen($lettre_motivation);

            // 5. Compute compatibility score
            $matchResult = $this->matchingService->calculateScore($candidat, $offre);

            // Store compatibility score in scores table
            Score::updateOrCreate(
                ['id_candidat' => $candidat->id_candidat, 'id_offre' => $offre->id_offre],
                [
                    'score_competences' => $matchResult['score_competences'],
                    'score_experience' => $matchResult['score_experience'],
                    'score_etudes' => $matchResult['score_etudes'],
                    'score_localisation' => $matchResult['score_localisation'],
                    'score_compatibilite' => $matchResult['score_compatibilite'],
                ]
            );

            // 6. Create or update Candidature
            if ($existing) {
                $candidature = $existing;
            } else {
                $candidature = new Candidature();
                $candidature->id_candidat = $candidat->id_candidat;
                $candidature->id_offre = $offre->id_offre;
            }
            $candidature->id_cv = $id_cv;
            $candidature->lettre_motivation = $lettre_motivation;
            $candidature->nom_lettre = $nom_lettre;
            $candidature->type_mime_lettre = $type_mime_lettre;
            $candidature->taille_lettre = $taille_lettre;
            $candidature->score_questionnaire = null;
            $candidature->score_final = $matchResult['score_compatibilite']; // default
            $candidature->save();

            // 7. Process questionnaire answers if applicable
            if ($offre->questionnaire) {
                if ($existing) {
                    Reponse::where('id_candidature', $candidature->id_candidature)->delete();
                }

                $totalQuestionnairePoints = 0;
                $earnedQuestionnairePoints = 0;

                $answers = $request->input('answers', []);
                foreach ($offre->questionnaire->questions as $question) {
                    $totalQuestionnairePoints += $question->points_question;
                    $reponseText = '';
                    $scoreReponse = 0;
                    $isCorrect = null;

                    if ($question->type_question === 'QCM') {
                        $selectedOptions = (array) ($answers[$question->id_question] ?? []);
                        $reponseText = implode(',', $selectedOptions);

                        // Calculate points
                        $correctOptions = $question->options->where('est_bonne_reponse', true)->pluck('id_option')->toArray();
                        $nbBonnesReponses = count($correctOptions);

                        if ($nbBonnesReponses > 0 && !empty($selectedOptions)) {
                            $correctSelected = array_intersect($selectedOptions, $correctOptions);
                            $nbBonnesCochees = count($correctSelected);
                            
                            // Check if exactly the correct ones are selected (for est_correcte status)
                            $incorrectSelected = array_diff($selectedOptions, $correctOptions);
                            $isCorrect = (count($correctSelected) === $nbBonnesReponses && count($incorrectSelected) === 0);

                            // Points formula: (points_question / nb_bonnes_reponses) * nb_bonnes_cochees
                            $scoreReponse = ($question->points_question / $nbBonnesReponses) * $nbBonnesCochees;
                        } else {
                            $isCorrect = false;
                            $scoreReponse = 0;
                        }
                        $earnedQuestionnairePoints += $scoreReponse;
                    } else {
                        // Response courte - auto-grade based on keywords
                        $reponseText = $answers[$question->id_question] ?? '';
                        $isCorrect = null;
                        $scoreReponse = 0;
                        
                        // Auto-grade if keywords are defined
                        if (!empty($question->mots_cles)) {
                            $keywords = array_map('trim', explode(',', $question->mots_cles));
                            $keywords = array_filter($keywords); // Remove empty values
                            
                            if (count($keywords) > 0) {
                                $reponseTextLower = strtolower($reponseText);
                                $matchedKeywords = 0;
                                
                                foreach ($keywords as $keyword) {
                                    if (stripos($reponseTextLower, strtolower($keyword)) !== false) {
                                        $matchedKeywords++;
                                    }
                                }
                                
                                // Calculate score: (matched_keywords / total_keywords) * points
                                if ($matchedKeywords > 0) {
                                    $scoreReponse = ($matchedKeywords / count($keywords)) * $question->points_question;
                                    $isCorrect = ($matchedKeywords === count($keywords)); // Correct only if all keywords matched
                                }
                                
                                $earnedQuestionnairePoints += $scoreReponse;
                            }
                        }
                    }

                    Reponse::create([
                        'id_question' => $question->id_question,
                        'id_candidature' => $candidature->id_candidature,
                        'contenu_reponse' => $reponseText,
                        'est_correcte' => $isCorrect,
                        'score_manuel' => null,
                        'score_reponse' => $scoreReponse,
                    ]);
                }

                // Normalise questionnaire score on 100
                $scoreQuestionnaireNorm = 0;
                if ($totalQuestionnairePoints > 0) {
                    $scoreQuestionnaireNorm = ($earnedQuestionnairePoints / $totalQuestionnairePoints) * 100;
                }

                $candidature->score_questionnaire = (int) round($scoreQuestionnaireNorm);
                
                // Final score formula: 60% compatibility + 40% questionnaire
                $candidature->score_final = (int) round(($matchResult['score_compatibilite'] * 0.6) + ($scoreQuestionnaireNorm * 0.4));
                $candidature->save();
            }

            // 8. Initialize recruitment steps (Progression) - only for new applications
            if (!$existing) {
                // Ensure first step is created and active
                $firstEtape = DB::table('etapes_offres')
                    ->where('id_offre', $offre->id_offre)
                    ->orderBy('ordre_etape', 'asc')
                    ->first();

                if ($firstEtape) {
                    ProgressionCandidature::create([
                        'id_candidature' => $candidature->id_candidature,
                        'id_etape_offre' => $firstEtape->id_etape_offre,
                        'statut_etape' => 'en_cours', // Active/Current
                        'declenchement' => 'automatique',
                        'date_validation' => now(),
                    ]);

                    // Create subsequent steps as pending
                    $otherEtapes = DB::table('etapes_offres')
                        ->where('id_offre', $offre->id_offre)
                        ->where('id_etape_offre', '!=', $firstEtape->id_etape_offre)
                        ->orderBy('ordre_etape', 'asc')
                        ->get();

                    foreach ($otherEtapes as $etape) {
                        ProgressionCandidature::create([
                            'id_candidature' => $candidature->id_candidature,
                            'id_etape_offre' => $etape->id_etape_offre,
                            'statut_etape' => 'en_attente',
                            'declenchement' => 'manuel',
                        ]);
                    }
                }

                // Update denormalized count on offres table
                $offre->increment('nb_candidatures');

                // Send notification to company
                $existingNotification = DB::table('notifications')
                    ->where('id_entreprise', $offre->id_entreprise)
                    ->whereNull('id_candidat')
                    ->where('type_notification', 'candidature')
                    ->where('statut_lecture', 'non lu')
                    ->first();

                if ($existingNotification) {
                    // Extract current count from existing notification content
                    $currentContent = $existingNotification->contenu_notification;
                    $currentCount = 1;
                    if (preg_match('/Vous avez reçu (\d+) nouvelle candidature/', $currentContent, $matches)) {
                        $currentCount = (int)$matches[1];
                    }
                    $newCount = $currentCount + 1;

                    // Update existing notification
                    DB::table('notifications')
                        ->where('id_notification', $existingNotification->id_notification)
                        ->update([
                            'titre_notification' => 'Nouvelle candidature',
                            'contenu_notification' => "Vous avez reçu $newCount nouvelle candidature" . ($newCount > 1 ? 's' : ''),
                            'id_reference' => $candidature->id_candidature,
                            'date_envoi' => now(),
                            'updated_at' => now(),
                        ]);
                } else {
                    // Create new notification
                    DB::table('notifications')->insert([
                        'id_entreprise' => $offre->id_entreprise,
                        'titre_notification' => 'Nouvelle candidature',
                        'contenu_notification' => 'Vous avez reçu 1 nouvelle candidature',
                        'type_notification' => 'candidature',
                        'id_reference' => $candidature->id_candidature,
                        'type_reference' => 'candidature',
                        'date_envoi' => now(),
                        'statut_lecture' => 'non lu',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            // Store data in session for confirmation page
            session([
                'titre_offre'        => $offre->titre_offre,
                'nom_entreprise'     => $offre->entreprise->nom_entreprise,
                'id_offre'           => $offre->id_offre,
                'score_final'        => $candidature->score_final,
                'score_compatibilite'=> $matchResult['score_compatibilite'],
                'score_questionnaire'=> $candidature->score_questionnaire,
            ]);

            return redirect()->route('candidat.candidature.envoyee');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de la soumission : ' . $e->getMessage()]);
        }
    }


    /**
     * Download CV PDF.
     */
    public function downloadCv($id_cv)
    {
        $cv = Cv::findOrFail($id_cv);
        
        // Authorize (recruteur or the owner candidate)
        $user = Auth::guard('entreprise')->user() ?? Auth::guard('candidat')->user();
        if (!$user) {
            abort(403);
        }

        return FacadeResponse::make($cv->contenu_fichier, 200, [
            'Content-Type' => $cv->type_mime,
            'Content-Disposition' => 'inline; filename="' . $cv->nom_fichier . '"',
        ]);
    }

    /**
     * Download Cover Letter.
     */
    public function downloadLettre($id_candidature)
    {
        $candidature = Candidature::findOrFail($id_candidature);
        
        // Authorize
        $user = Auth::guard('entreprise')->user() ?? Auth::guard('candidat')->user();
        if (!$user) {
            abort(403);
        }

        if ($candidature->type_mime_lettre === 'text/plain') {
            return FacadeResponse::make($candidature->lettre_motivation, 200, [
                'Content-Type' => 'text/plain; charset=utf-8',
                'Content-Disposition' => 'inline; filename="' . $candidature->nom_lettre . '"',
            ]);
        }

        return FacadeResponse::make($candidature->lettre_motivation, 200, [
            'Content-Type' => $candidature->type_mime_lettre,
            'Content-Disposition' => 'inline; filename="' . $candidature->nom_lettre . '"',
        ]);
    }

    /**
     * Update internal recruteur note on candidature.
     */
    public function updateNote(Request $request, $id_candidature)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $candidature = Candidature::findOrFail($id_candidature);

        // Verify ownership
        if ($candidature->offre->id_entreprise !== $entreprise->id_entreprise) {
            abort(403);
        }

        $request->validate(['note_interne' => 'nullable|string']);
        $candidature->update(['note_interne' => $request->input('note_interne')]);

        return redirect()->back()->with('success', 'Note interne mise à jour.');
    }

    /**
     * Reject candidature.
     */
    public function reject(Request $request, $id_candidature)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $candidature = Candidature::findOrFail($id_candidature);

        if ($candidature->offre->id_entreprise !== $entreprise->id_entreprise) {
            abort(403);
        }

        $request->validate(['motif_refus' => 'required|string|max:255']);
        
        DB::transaction(function () use ($candidature, $request) {
            $candidature->update([
                'motif_refus' => $request->input('motif_refus')
            ]);

            // Mark all steps as completed/failed or update status
            ProgressionCandidature::where('id_candidature', $candidature->id_candidature)
                ->where('statut_etape', 'en_cours')
                ->update(['statut_etape' => 'complétée']);

            // Send notification to Candidate
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
                        'titre_notification' => 'Candidature refusée',
                        'contenu_notification' => 'Votre candidature pour le poste ' . $candidature->offre->titre_offre . ' n\'a pas été retenue. Motif : ' . $request->input('motif_refus'),
                        'id_reference' => $candidature->id_candidature,
                        'date_envoi' => now(),
                        'updated_at' => now(),
                    ]);
            } else {
                // Create new notification
                DB::table('notifications')->insert([
                    'id_candidat' => $candidature->id_candidat,
                    'titre_notification' => 'Candidature refusée',
                    'contenu_notification' => 'Votre candidature pour le poste ' . $candidature->offre->titre_offre . ' n\'a pas été retenue. Motif : ' . $request->input('motif_refus'),
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

        return redirect()->back()->with('success', 'Candidature refusée.');
    }

    /**
     * Delete candidature (candidate side).
     */
    public function destroy($id_candidature)
    {
        $candidat = Auth::guard('candidat')->user();
        $candidature = Candidature::findOrFail($id_candidature);

        if ($candidature->id_candidat !== $candidat->id_candidat) {
            abort(403);
        }

        DB::transaction(function () use ($candidature) {
            // Delete related records
            ProgressionCandidature::where('id_candidature', $candidature->id_candidature)->delete();
            Reponse::where('id_candidature', $candidature->id_candidature)->delete();
            
            // Delete the candidature
            $candidature->delete();
            
            // Update offer count
            $candidature->offre->decrement('nb_candidatures');
        });

        return redirect()->route('candidat.dashboard')->with('success', 'Candidature supprimée avec succès.');
    }
}
