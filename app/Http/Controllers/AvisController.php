<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Entreprise;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AvisController extends Controller
{
    /**
     * Submit an evaluation review.
     */
    public function store(Request $request, $id_entreprise)
    {
        $candidat = Auth::guard('candidat')->user();
        $entreprise = Entreprise::findOrFail($id_entreprise);

        // Verify candidate has at least one application with this company and has passed interview stage
        $candidatures = Candidature::where('id_candidat', $candidat->id_candidat)
            ->whereHas('offre', function($query) use ($id_entreprise) {
                $query->where('id_entreprise', $id_entreprise);
            })
            ->with('progressions.etapeOffre')
            ->get();

        if ($candidatures->isEmpty()) {
            return redirect()->back()->withErrors(['error' => 'Vous devez avoir au moins une candidature chez cette entreprise pour laisser un avis.']);
        }

        // Check if any candidature has passed interview stage (has a completed interview progression)
        $hasPassedInterview = $candidatures->contains(function($candidature) {
            return $candidature->progressions->contains(function($progression) {
                return str_contains(strtolower($progression->etapeOffre->nom_etape ?? ''), 'entretien') 
                    && $progression->statut_etape === 'complétée';
            });
        });

        if (!$hasPassedInterview) {
            return redirect()->back()->withErrors(['error' => 'Vous devez avoir passé le stade entretien pour laisser un avis.']);
        }

        $request->validate([
            'note_clarte_offre' => 'required|integer|min:1|max:5',
            'note_qualite_retours' => 'required|integer|min:1|max:5',
            'note_respect_processus' => 'required|integer|min:1|max:5',
            'note_professionnalisme' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        // Calculate global note
        $noteGlobale = (int) round((
            $request->input('note_clarte_offre') +
            $request->input('note_qualite_retours') +
            $request->input('note_respect_processus') +
            $request->input('note_professionnalisme')
        ) / 4);

        // Use the first eligible candidature for the review
        $eligibleCandidature = $candidatures->first(function($candidature) {
            return $candidature->progressions->contains(function($progression) {
                return str_contains(strtolower($progression->etapeOffre->nom_etape ?? ''), 'entretien') 
                    && $progression->statut_etape === 'complétée';
            });
        });

        DB::transaction(function () use ($request, $candidat, $id_entreprise, $noteGlobale) {
            // Create review with nullable id_candidature (allows multiple reviews per company)
            Avis::create([
                'id_candidat' => $candidat->id_candidat,
                'id_entreprise' => $id_entreprise,
                'id_candidature' => null,
                'note_globale' => $noteGlobale,
                'commentaire' => $request->input('commentaire'),
                'note_clarte_offre' => $request->input('note_clarte_offre'),
                'note_qualite_retours' => $request->input('note_qualite_retours'),
                'note_respect_processus' => $request->input('note_respect_processus'),
                'note_professionnalisme' => $request->input('note_professionnalisme'),
                'date_avis' => now(),
                'statut_avis' => 'publié',
            ]);

            // Recalculate average note for the company
            $avg = Avis::where('id_entreprise', $id_entreprise)
                ->where('statut_avis', 'publié')
                ->avg('note_globale');

            Entreprise::where('id_entreprise', $id_entreprise)->update([
                'note_moyenne' => $avg ? round($avg, 2) : 0
            ]);

            // Notify company about new review
            DB::table('notifications')->insert([
                'id_entreprise' => $id_entreprise,
                'titre_notification' => 'Nouvel avis candidat',
                'contenu_notification' => 'Un candidat a déposé un avis sur votre processus de recrutement. Note globale : ' . $noteGlobale . '/5',
                'type_notification' => 'moderation',
                'date_envoi' => now(),
                'statut_lecture' => 'non lu',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Votre avis a été soumis avec succès.');
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, $id_avis)
    {
        $candidat = Auth::guard('candidat')->user();
        $avis = Avis::findOrFail($id_avis);

        // Verify ownership
        if ($avis->id_candidat !== $candidat->id_candidat) {
            abort(403);
        }

        $request->validate([
            'note_clarte_offre' => 'required|integer|min:1|max:5',
            'note_qualite_retours' => 'required|integer|min:1|max:5',
            'note_respect_processus' => 'required|integer|min:1|max:5',
            'note_professionnalisme' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        // Calculate global note
        $noteGlobale = (int) round((
            $request->input('note_clarte_offre') +
            $request->input('note_qualite_retours') +
            $request->input('note_respect_processus') +
            $request->input('note_professionnalisme')
        ) / 4);

        DB::transaction(function () use ($request, $avis, $noteGlobale) {
            $idEntreprise = $avis->id_entreprise;

            // Update review
            $avis->update([
                'note_globale' => $noteGlobale,
                'commentaire' => $request->input('commentaire'),
                'note_clarte_offre' => $request->input('note_clarte_offre'),
                'note_qualite_retours' => $request->input('note_qualite_retours'),
                'note_respect_processus' => $request->input('note_respect_processus'),
                'note_professionnalisme' => $request->input('note_professionnalisme'),
                'date_avis' => now(),
            ]);

            // Recalculate average note for the company
            $avg = Avis::where('id_entreprise', $idEntreprise)
                ->where('statut_avis', 'publié')
                ->avg('note_globale');

            Entreprise::where('id_entreprise', $idEntreprise)->update([
                'note_moyenne' => $avg ? round($avg, 2) : 0
            ]);
        });

        return redirect()->back()->with('success', 'Votre avis a été modifié avec succès.');
    }

    /**
     * Delete a review.
     */
    public function destroy($id_avis)
    {
        $candidat = Auth::guard('candidat')->user();
        $avis = Avis::findOrFail($id_avis);

        // Verify ownership
        if ($avis->id_candidat !== $candidat->id_candidat) {
            abort(403);
        }

        $idEntreprise = $avis->id_entreprise;

        DB::transaction(function () use ($avis, $idEntreprise) {
            // Delete review
            $avis->delete();

            // Recalculate average note for the company
            $avg = Avis::where('id_entreprise', $idEntreprise)
                ->where('statut_avis', 'publié')
                ->avg('note_globale');

            Entreprise::where('id_entreprise', $idEntreprise)->update([
                'note_moyenne' => $avg ? round($avg, 2) : 0
            ]);
        });

        return redirect()->back()->with('success', 'Votre avis a été supprimé avec succès.');
    }
}
