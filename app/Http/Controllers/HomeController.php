<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre;
use App\Models\Entreprise;
use App\Models\Candidat;

class HomeController extends Controller
{
    /**
     * Display the public home page.
     */
    public function index()
    {
        $stats = [
            'offres' => Offre::count(),
            'entreprises' => Entreprise::count(),
            'candidats' => Candidat::count(),
        ];

        // Fetch latest offers with company info
        $offres = Offre::with('entreprise')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Fetch companies with their offer count
        $entreprises = Entreprise::withCount('offres')
            ->orderBy('offres_count', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('stats', 'offres', 'entreprises'));
    }
}
