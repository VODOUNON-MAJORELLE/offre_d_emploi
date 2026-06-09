<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\ProgressionCandidature;
use App\Models\EtapeOffre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgressionController extends Controller
{
    /**
     * Update the status of a specific progression step.
     */
    public function updateStatus(Request $request, $id_progression)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $progression = ProgressionCandidature::with('etapeOffre.offre')->findOrFail($id_progression);

        // Verify ownership
        if ($progression->etapeOffre->offre->id_entreprise !== $entreprise->id_entreprise) {
            abort(403);
        }

        $request->validate([
            'statut_etape' => 'required|in:en_attente,en_cours,complétée',
        ]);

        $statutEtape = $request->input('statut_etape');

        DB::transaction(function () use ($progression, $statutEtape) {
            // Update current step
            $progression->update([
                'statut_etape' => $statutEtape,
                'date_validation' => $statutEtape === 'complétée' ? now() : null,
            ]);

            // If we mark this step as completed, set the next step to 'en_cours'
            if ($statutEtape === 'complétée') {
                $currentEtape = $progression->etapeOffre;
                $candidature = $progression->candidature;

                $nextEtape = EtapeOffre::where('id_offre', $candidature->id_offre)
                    ->where('ordre_etape', '>', $currentEtape->ordre_etape)
                    ->orderBy('ordre_etape', 'asc')
                    ->first();

                if ($nextEtape) {
                    ProgressionCandidature::where('id_candidature', $candidature->id_candidature)
                        ->where('id_etape_offre', $nextEtape->id_etape_offre)
                        ->update([
                            'statut_etape' => 'en_cours',
                            'date_validation' => now()
                        ]);

                    // Send notification to Candidate
                    $existingNotification = DB::table('notifications')
                        ->where('id_candidat', $candidature->id_candidat)
                        ->where('id_reference', $candidature->id_candidature)
                        ->where('type_reference', 'candidature')
                        ->where('type_notification', 'statut')
                        ->where('statut_lecture', 'non lu')
                        ->first();

                    if ($existingNotification) {
                        // Update existing notification
                        DB::table('notifications')
                            ->where('id_notification', $existingNotification->id_notification)
                            ->update([
                                'titre_notification' => 'Recrutement : Étape suivante',
                                'contenu_notification' => 'Votre candidature pour le poste ' . $candidature->offre->titre_offre . ' est passée à l\'étape : ' . $nextEtape->nom_etape,
                                'id_reference' => $candidature->id_candidature,
                                'date_envoi' => now(),
                                'updated_at' => now(),
                            ]);
                    } else {
                        // Create new notification
                        DB::table('notifications')->insert([
                            'id_candidat' => $candidature->id_candidat,
                            'titre_notification' => 'Recrutement : Étape suivante',
                            'contenu_notification' => 'Votre candidature pour le poste ' . $candidature->offre->titre_offre . ' est passée à l\'étape : ' . $nextEtape->nom_etape,
                            'type_notification' => 'statut',
                            'id_reference' => $candidature->id_candidature,
                            'type_reference' => 'candidature',
                            'date_envoi' => now(),
                            'statut_lecture' => 'non lu',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } else {
                    // This was the final step! Mark candidature as final/completed or accepted
                    // Send final notification
                    DB::table('notifications')->insert([
                        'id_candidat' => $candidature->id_candidat,
                        'titre_notification' => 'Recrutement terminé',
                        'contenu_notification' => 'Félicitations, le processus de recrutement pour le poste ' . $candidature->offre->titre_offre . ' est terminé !',
                        'type_notification' => 'statut',
                        'id_reference' => $candidature->id_candidature,
                        'type_reference' => 'candidature',
                        'date_envoi' => now(),
                        'statut_lecture' => 'non lu',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Statut de l\'étape mis à jour.');
    }

    /**
     * Advance the candidate's recruitment step manually.
     */
    public function advanceStep(Request $request, $id_candidature)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $candidature = Candidature::with('offre')->findOrFail($id_candidature);

        // Verify ownership
        if ($candidature->offre->id_entreprise !== $entreprise->id_entreprise) {
            abort(403);
        }

        $request->validate([
            'id_progression' => 'required|integer|exists:progression_candidatures,id_progression',
            'statut_etape' => 'required|in:en_cours,complétée',
        ]);

        $idProgression = $request->input('id_progression');
        $statutEtape = $request->input('statut_etape');

        DB::transaction(function () use ($idProgression, $statutEtape, $candidature) {
            $currentProgression = ProgressionCandidature::findOrFail($idProgression);
            
            // Update current step
            $currentProgression->update([
                'statut_etape' => $statutEtape,
                'date_validation' => $statutEtape === 'complétée' ? now() : $currentProgression->date_validation,
            ]);

            // If we mark this step as completed, set the next step to 'en_cours'
            if ($statutEtape === 'complétée') {
                $currentEtape = EtapeOffre::findOrFail($currentProgression->id_etape_offre);
                
                $nextEtape = EtapeOffre::where('id_offre', $candidature->id_offre)
                    ->where('ordre_etape', '>', $currentEtape->ordre_etape)
                    ->orderBy('ordre_etape', 'asc')
                    ->first();

                if ($nextEtape) {
                    ProgressionCandidature::where('id_candidature', $candidature->id_candidature)
                        ->where('id_etape_offre', $nextEtape->id_etape_offre)
                        ->update([
                            'statut_etape' => 'en_cours',
                            'date_validation' => now()
                        ]);

                    // Send notification to Candidate
                    $existingNotification = DB::table('notifications')
                        ->where('id_candidat', $candidature->id_candidat)
                        ->where('id_reference', $candidature->id_candidature)
                        ->where('type_reference', 'candidature')
                        ->where('type_notification', 'statut')
                        ->where('statut_lecture', 'non lu')
                        ->first();

                    if ($existingNotification) {
                        // Update existing notification
                        DB::table('notifications')
                            ->where('id_notification', $existingNotification->id_notification)
                            ->update([
                                'titre_notification' => 'Recrutement : Étape suivante',
                                'contenu_notification' => 'Votre candidature pour le poste ' . $candidature->offre->titre_offre . ' est passée à l\'étape : ' . $nextEtape->nom_etape,
                                'id_reference' => $candidature->id_candidature,
                                'date_envoi' => now(),
                                'updated_at' => now(),
                            ]);
                    } else {
                        // Create new notification
                        DB::table('notifications')->insert([
                            'id_candidat' => $candidature->id_candidat,
                            'titre_notification' => 'Recrutement : Étape suivante',
                            'contenu_notification' => 'Votre candidature pour le poste ' . $candidature->offre->titre_offre . ' est passée à l\'étape : ' . $nextEtape->nom_etape,
                            'type_notification' => 'statut',
                            'id_reference' => $candidature->id_candidature,
                            'type_reference' => 'candidature',
                            'date_envoi' => now(),
                            'statut_lecture' => 'non lu',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } else {
                    // This was the final step! Mark candidature as final/completed or accepted
                    // Send final notification
                    DB::table('notifications')->insert([
                        'id_candidat' => $candidature->id_candidat,
                        'titre_notification' => 'Recrutement terminé',
                        'contenu_notification' => 'Félicitations, le processus de recrutement pour le poste ' . $candidature->offre->titre_offre . ' est terminé !',
                        'type_notification' => 'statut',
                        'id_reference' => $candidature->id_candidature,
                        'type_reference' => 'candidature',
                        'date_envoi' => now(),
                        'statut_lecture' => 'non lu',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Étape de recrutement mise à jour.');
    }
}
