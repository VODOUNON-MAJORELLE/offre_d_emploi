<?php
namespace App\Http\Controllers;

use App\Models\Offre;
use Illuminate\Http\Request;

class ProgressionCandidatureController extends Controller
{
    public function index()
    {
        $id = session('entreprise_id');
        $offres = Offre::where('id_entreprise', $id)->pluck('id_offre');
        $candidatures = collect(); // sera rempli quand Majorelle aura sa table
        return view('entreprise.candidatures.index', compact('candidatures'));
    }

    public function show($id)
    {
        return view('entreprise.candidatures.show');
    }

    public function avancer(Request $request, $id) { return back(); }
    public function refuser(Request $request, $id) { return back(); }
    public function ajouterNote(Request $request, $id) { return back(); }
}