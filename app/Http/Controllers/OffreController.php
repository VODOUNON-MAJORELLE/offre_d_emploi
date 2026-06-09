<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Entreprise;
use App\Models\EtapeOffre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffreController extends Controller
{
    /**
     * Show the form for editing the specified offer.
     */
    public function edit($id_offre)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);
        $etapes = \App\Models\EtapeOffre::where('id_offre', $id_offre)->orderBy('ordre_etape')->get();
        return view('entreprise.offre-edit', compact('offre', 'etapes'));
    }

    /**
     * Update the specified offer in storage.
     */
    public function update(Request $request, $id_offre)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);

        $validated = $request->validate([
            'titre_offre' => 'required|string|max:255',
            'ville_poste' => 'required|string|max:255',
            'pays' => 'nullable|string|max:255',
            'description_offre' => 'required|string',
            'type_contrat' => 'nullable|string|max:50',
            'teletravail' => 'nullable|string|max:50',
            'niveau_etudes_requis' => 'nullable|in:Bac,Licence,Master,Doctorat',
            'experience_requise' => 'nullable|string|max:50',
            'salaire_min' => 'nullable|integer',
            'salaire_max' => 'nullable|integer',
            'devise' => 'nullable|string|max:10',
            'date_limite' => 'nullable|date',
            'competences_requises' => 'nullable|string|max:1000',
            'etapes_json' => 'nullable|string',
            'questions_json' => 'nullable|string',
        ]);

        $offre->update([
            'titre_offre' => $validated['titre_offre'],
            'ville_poste' => $validated['ville_poste'],
            'pays' => $validated['pays'] ?? $offre->pays,
            'description_offre' => $validated['description_offre'],
            'type_contrat' => $validated['type_contrat'] ?? $offre->type_contrat,
            'teletravail' => $validated['teletravail'] ?? $offre->teletravail,
            'niveau_etudes_requis' => $validated['niveau_etudes_requis'] ?? $offre->niveau_etudes_requis,
            'experience_requise' => $validated['experience_requise'] ?? $offre->experience_requise,
            'salaire_min' => $validated['salaire_min'],
            'salaire_max' => $validated['salaire_max'],
            'devise' => $validated['devise'] ?? $offre->devise,
            'date_limite' => $validated['date_limite'],
            'competences_requises' => $validated['competences_requises'] ?? $offre->competences_requises,
            'questions_json' => $request->has('questions_json') ? $request->questions_json : $offre->questions_json,
        ]);

        // Update recruitment steps if provided
        if ($request->has('etapes_json') && !empty($request->etapes_json)) {
            $etapes = json_decode($request->etapes_json, true);
            if (is_array($etapes) && count($etapes) > 0) {
                // Delete existing steps
                \App\Models\EtapeOffre::where('id_offre', $offre->id_offre)->delete();
                // Create new steps
                foreach ($etapes as $index => $etapeNom) {
                    \App\Models\EtapeOffre::create([
                        'id_offre' => $offre->id_offre,
                        'nom_etape' => $etapeNom,
                        'ordre_etape' => $index + 1,
                    ]);
                }
            }
        }

        // Update questionnaire if provided
        if ($request->has('questions_json') && !empty($request->questions_json)) {
            $questionsData = json_decode($request->questions_json, true);
            if (is_array($questionsData) && count($questionsData) > 0) {
                DB::beginTransaction();
                try {
                    // Delete existing questionnaire if any
                    if ($offre->questionnaire) {
                        $offre->questionnaire->delete();
                    }

                    // Create new questionnaire
                    $questionnaire = \App\Models\Questionnaire::create([
                        'id_offre' => $offre->id_offre,
                        'titre_questionnaire' => 'Questionnaire pour ' . $offre->titre_offre,
                    ]);

                    // Create questions
                    foreach ($questionsData as $qData) {
                        $question = \App\Models\Question::create([
                            'id_questionnaire' => $questionnaire->id_questionnaire,
                            'enonce_question' => $qData['q'],
                            'type_question' => $qData['t'] === 'qcm' ? 'QCM' : 'reponse_courte',
                            'points_question' => (int) ($qData['points'] ?? 10),
                        ]);

                        // Create options for QCM questions
                        if ($qData['t'] === 'qcm' && isset($qData['options']) && is_array($qData['options'])) {
                            foreach ($qData['options'] as $optIndex => $optionText) {
                                \App\Models\OptionReponse::create([
                                    'id_question' => $question->id_question,
                                    'contenu_option' => $optionText,
                                    'est_bonne_reponse' => false, // Default to false, can be modified later
                                    'ordre_option' => $optIndex + 1,
                                ]);
                            }
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::error('Error updating questionnaire: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('entreprise.offres.detail', ['id_offre' => $offre->id_offre])
            ->with('success', 'Offre mise à jour avec succès !');
    }

    /**
     * Suspend the specified offer.
     */
    public function suspend($id_offre)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);
        $offre->update(['statut_offre' => 'suspendue']);
        return redirect()->back()->with('success', 'Offre suspendue avec succès.');
    }

    /**
     * Close the specified offer.
     */
    public function close($id_offre)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);
        $offre->update(['statut_offre' => 'clôturée']);
        return redirect()->back()->with('success', 'Offre clôturée avec succès.');
    }

    /**
     * Reactivate the specified offer.
     */
    public function reactivate($id_offre)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);
        $offre->update(['statut_offre' => 'active']);
        return redirect()->back()->with('success', 'Offre réactivée avec succès.');
    }

    /**
     * Store a newly created offer in storage.
     */
    public function store(Request $request)
    {
        $entreprise = Auth::guard('entreprise')->user();

        $validated = $request->validate([
            'titre_offre' => 'required|string|max:255',
            'ville_poste' => 'required|string|max:255',
            'pays' => 'nullable|string|max:255',
            'description_offre' => 'nullable|string',
            'type_contrat' => 'nullable|string|max:50',
            'niveau_etudes_requis' => 'nullable|in:Bac,Licence,Master,Doctorat',
            'experience_requise' => 'nullable|string|max:50',
            'salaire_min' => 'nullable|integer',
            'salaire_max' => 'nullable|integer',
            'devise' => 'nullable|string|max:10',
            'date_limite' => 'nullable|date',
            'competences_requises' => 'nullable|string|max:1000',
            'questions_json' => 'nullable|string',
            'etapes_json' => 'nullable|string',
        ]);

        // Use company's default currency if not specified
        $devise = $validated['devise'] ?? $entreprise->devise ?? 'FCFA';
        $pays = $validated['pays'] ?? $entreprise->pays ?? 'Bénin';

        // Create the offer
        $offre = Offre::create([
            'id_entreprise' => $entreprise->id_entreprise,
            'titre_offre' => $validated['titre_offre'],
            'ville_poste' => $validated['ville_poste'],
            'pays' => $pays,
            'description_offre' => $validated['description_offre'],
            'type_contrat' => $validated['type_contrat'] ?? null,
            'niveau_etudes_requis' => $validated['niveau_etudes_requis'] ?? null,
            'experience_requise' => $validated['experience_requise'] ?? null,
            'salaire_min' => $validated['salaire_min'],
            'salaire_max' => $validated['salaire_max'],
            'devise' => $devise,
            'date_limite' => $validated['date_limite'] ?? null,
            'competences_requises' => $validated['competences_requises'] ?? null,
            'statut_offre' => 'active',
            'date_publication' => now(),
            'nb_candidatures' => 0,
        ]);

        \Log::info('Offre créée avec succès', ['id_offre' => $offre->id_offre, 'titre' => $offre->titre_offre]);

        // Create recruitment steps if provided
        if ($request->has('etapes_json') && !empty($request->etapes_json)) {
            $etapes = json_decode($request->etapes_json, true);
            if (is_array($etapes) && count($etapes) > 0) {
                foreach ($etapes as $index => $etapeNom) {
                    EtapeOffre::create([
                        'id_offre' => $offre->id_offre,
                        'nom_etape' => $etapeNom,
                        'ordre_etape' => $index + 1,
                    ]);
                }
            }
        } else {
            // Create default steps if none provided
            $defaultEtapes = ['Candidature reçue', 'En cours d\'examen', 'Entretien', 'Test technique', 'Réponse finale'];
            foreach ($defaultEtapes as $index => $etapeNom) {
                EtapeOffre::create([
                    'id_offre' => $offre->id_offre,
                    'nom_etape' => $etapeNom,
                    'ordre_etape' => $index + 1,
                ]);
            }
        }

        // Create questionnaire if provided
        if ($request->has('questions_json') && !empty($request->questions_json)) {
            $questionsData = json_decode($request->questions_json, true);
            if (is_array($questionsData) && count($questionsData) > 0) {
                DB::beginTransaction();
                try {
                    // Create new questionnaire
                    $questionnaire = \App\Models\Questionnaire::create([
                        'id_offre' => $offre->id_offre,
                        'titre_questionnaire' => 'Questionnaire pour ' . $offre->titre_offre,
                    ]);

                    // Create questions
                    foreach ($questionsData as $qData) {
                        $question = \App\Models\Question::create([
                            'id_questionnaire' => $questionnaire->id_questionnaire,
                            'enonce_question' => $qData['q'],
                            'type_question' => $qData['t'] === 'qcm' ? 'QCM' : 'reponse_courte',
                            'points_question' => (int) ($qData['points'] ?? 10),
                        ]);

                        // Create options for QCM questions
                        if ($qData['t'] === 'qcm' && isset($qData['options']) && is_array($qData['options'])) {
                            foreach ($qData['options'] as $optIndex => $optionText) {
                                \App\Models\OptionReponse::create([
                                    'id_question' => $question->id_question,
                                    'contenu_option' => $optionText,
                                    'est_bonne_reponse' => false, // Default to false, can be modified later
                                    'ordre_option' => $optIndex + 1,
                                ]);
                            }
                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::error('Error creating questionnaire: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('entreprise.offres.create')
            ->with('newOffreId', $offre->id_offre)
            ->with('success', 'Offre créée avec succès !')
            ->with('titre_offre', $offre->titre_offre);
    }
}
