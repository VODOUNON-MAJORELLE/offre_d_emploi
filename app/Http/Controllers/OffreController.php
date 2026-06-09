<?php
namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Questionnaire;
use App\Models\EtapeOffre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index()
    {
        $id = session('entreprise_id');
        $offres = Offre::where('id_entreprise', $id)->latest()->get();
        return view('entreprise.offres.index', compact('offres'));
    }

    public function create()
    {
        return view('entreprise.offres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre_offre'          => 'required|string|max:255',
            'description_offre'    => 'required|string',
            'ville_poste'          => 'nullable|string',
            'type_contrat'         => 'required|string',
            'salaire_min'          => 'nullable|numeric',
            'salaire_max'          => 'nullable|numeric',
            'date_limite'          => 'nullable|date',
            'experience_requise'   => 'nullable|integer',
            'niveau_etudes_requis' => 'nullable|string',
            'competences_requises' => 'nullable|string',
        ]);

        $offre = Offre::create([
            'id_entreprise'        => session('entreprise_id'),
            'titre_offre'          => $request->titre_offre,
            'description_offre'    => $request->description_offre,
            'ville_poste'          => $request->ville_poste,
            'type_contrat'         => $request->type_contrat,
            'salaire_min'          => $request->salaire_min,
            'salaire_max'          => $request->salaire_max,
            'date_limite'          => $request->date_limite,
            'experience_requise'   => $request->experience_requise ?? 0,
            'niveau_etudes_requis' => $request->niveau_etudes_requis,
            'competences_requises' => $request->competences_requises,
            'statut_offre'         => 'en_attente',
            'nb_candidatures'      => 0,
        ]);

        // Redirige vers edit pour configurer questionnaire et processus
        return redirect()->route('entreprise.offres.edit', $offre->id_offre)
            ->with('success', 'Offre créée ! Complétez maintenant le questionnaire et le processus.');
    }

    public function show($id)
    {
        $offre = Offre::where('id_offre', $id)
            ->where('id_entreprise', session('entreprise_id'))
            ->firstOrFail();
        $candidatures = collect();
        return view('entreprise.offres.show', compact('offre', 'candidatures'));
    }

    public function edit($id)
    {
        $offre = Offre::where('id_offre', $id)
            ->where('id_entreprise', session('entreprise_id'))
            ->firstOrFail();
        $etapes = EtapeOffre::where('id_offre', $id)->orderBy('ordre_etape')->get();
        $questionnaire = Questionnaire::where('id_offre', $id)
            ->with('questions.options')->first();
        return view('entreprise.offres.edit', compact('offre', 'etapes', 'questionnaire'));
    }

    public function update(Request $request, $id)
    {
        $offre = Offre::where('id_offre', $id)
            ->where('id_entreprise', session('entreprise_id'))
            ->firstOrFail();

        $offre->update($request->only([
            'titre_offre', 'description_offre', 'ville_poste',
            'type_contrat', 'salaire_min', 'salaire_max',
            'date_limite', 'experience_requise',
            'niveau_etudes_requis', 'competences_requises',
        ]));

        return back()->with('success', 'Offre mise à jour !');
    }

    public function changerStatut(Request $request, $id)
    {
        $offre = Offre::where('id_offre', $id)
            ->where('id_entreprise', session('entreprise_id'))
            ->firstOrFail();

        $offre->update(['statut_offre' => $request->statut]);

        return back()->with('success', 'Statut mis à jour !');
    }
}