<?php
namespace App\Http\Controllers;

use App\Models\EtapeOffre;
use Illuminate\Http\Request;

class EtapeOffreController extends Controller
{
    public function store(Request $request, $id_offre)
    {
        $request->validate(['nom_etape' => 'required|string|max:255']);

        $ordre = EtapeOffre::where('id_offre', $id_offre)->max('ordre_etape') + 1;

        EtapeOffre::create([
            'id_offre'       => $id_offre,
            'nom_etape'      => $request->nom_etape,
            'ordre_etape'    => $ordre,
            'est_obligatoire'=> true,
        ]);

        return back()->with('success', 'Étape ajoutée !');
    }

    public function destroy($id)
    {
        EtapeOffre::findOrFail($id)->delete();
        return back()->with('success', 'Étape supprimée !');
    }
}