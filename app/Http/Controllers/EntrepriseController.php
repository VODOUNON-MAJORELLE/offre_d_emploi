<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EntrepriseController extends Controller
{
    public function dashboard()
    {
        $id = session('entreprise_id');

        $offres_recentes = Offre::where('id_entreprise', $id)
            ->where('statut_offre', 'active')
            ->latest()
            ->take(3)
            ->get();

        $top_candidats = collect();

        $stats = [
            'offres_actives' => Offre::where('id_entreprise', $id)->where('statut_offre', 'active')->count(),
            'total_candidatures' => Offre::where('id_entreprise', $id)->sum('nb_candidatures'),
            'entretiens' => 0,
            'taux_conversion' => 0,
        ];

        return view('entreprise.dashboard', compact('stats', 'offres_recentes', 'top_candidats'));
    }

    public function profil()
    {
        $entreprise = Entreprise::find(session('entreprise_id'));
        $offres = Offre::where('id_entreprise', session('entreprise_id'))->latest()->get();
        $stats = [
            'offres' => $offres->count(),
            'candidatures' => $offres->sum('nb_candidatures'),
            'embauches' => 0,
        ];
        return view('entreprise.profil', compact('entreprise', 'offres', 'stats'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'secteur_activite' => 'nullable|string|max:255',
            'ville_entreprise' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);

        $entreprise = Entreprise::find(session('entreprise_id'));

        $data = $request->only([
            'nom_entreprise',
            'secteur_activite',
            'ville_entreprise',
            'description',
            'telephone',
        ]);

        if ($request->hasFile('logo')) {
            if ($entreprise->logo) {
                Storage::disk('public')->delete($entreprise->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $entreprise->update($data);
        session(['entreprise' => $entreprise->fresh()]);

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}