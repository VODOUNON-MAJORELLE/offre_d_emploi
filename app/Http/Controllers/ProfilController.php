<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // ── EXPERIENCES ─────────────────────────────────────────────────────────

    public function storeExperience(Request $request)
    {
        $request->validate([
            'poste'       => 'required|string|max:255',
            'entreprise'  => 'required|string|max:255',
            'annee_debut' => 'required|string|max:10',
            'annee_fin'   => 'nullable|string|max:10',
            'description' => 'nullable|string|max:1000',
        ]);

        $candidat = Auth::guard('candidat')->user();

        Experience::create([
            'id_candidat' => $candidat->id_candidat,
            'poste'       => $request->poste,
            'entreprise'  => $request->entreprise,
            'annee_debut' => $request->annee_debut,
            'annee_fin'   => $request->annee_fin ?: null,
            'description' => $request->description,
        ]);

        return redirect()->route('candidat.profil')->with('success', 'Expérience ajoutée avec succès.');
    }

    public function destroyExperience($id)
    {
        $candidat = Auth::guard('candidat')->user();
        $exp = Experience::where('id_candidat', $candidat->id_candidat)->findOrFail($id);
        $exp->delete();

        return redirect()->route('candidat.profil')->with('success', 'Expérience supprimée.');
    }

    // ── FORMATIONS ──────────────────────────────────────────────────────────

    public function storeFormation(Request $request)
    {
        $request->validate([
            'diplome'       => 'required|string|max:255',
            'etablissement' => 'required|string|max:255',
            'annee_debut'   => 'required|string|max:10',
            'annee_fin'     => 'nullable|string|max:10',
            'description'   => 'nullable|string|max:1000',
        ]);

        $candidat = Auth::guard('candidat')->user();

        Formation::create([
            'id_candidat'   => $candidat->id_candidat,
            'diplome'       => $request->diplome,
            'etablissement' => $request->etablissement,
            'annee_debut'   => $request->annee_debut,
            'annee_fin'     => $request->annee_fin ?: null,
            'description'   => $request->description,
        ]);

        return redirect()->route('candidat.profil')->with('success', 'Formation ajoutée avec succès.');
    }

    public function destroyFormation($id)
    {
        $candidat = Auth::guard('candidat')->user();
        $formation = Formation::where('id_candidat', $candidat->id_candidat)->findOrFail($id);
        $formation->delete();

        return redirect()->route('candidat.profil')->with('success', 'Formation supprimée.');
    }
}
