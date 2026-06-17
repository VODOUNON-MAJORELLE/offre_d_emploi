<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Score;
use App\Models\Offre;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidatController extends Controller
{
    protected MatchingService $matchingService;

    public function __construct(MatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }
    public function showProfile()
    {
        $candidat = Auth::guard('candidat')->user();
        $cvs = $candidat->cvs()->where('statut', 'actif')->orderByDesc('date_upload')->get();
        $principalCv = $candidat->principalCv;
        $competences = array_filter(array_map('trim', explode(',', $candidat->competences ?? '')));

        $steps = [
            'photo'      => !empty($candidat->photo_profil),
            'telephone'  => !empty($candidat->telephone),
            'cv'         => !empty($principalCv),
            'competences'=> count($competences) > 0,
        ];

        $completion = round(array_sum($steps) / count($steps) * 100);

        $experiences = \App\Models\Experience::where('id_candidat', $candidat->id_candidat)
            ->orderByDesc('annee_debut')
            ->get();

        $formations = \App\Models\Formation::where('id_candidat', $candidat->id_candidat)
            ->orderByDesc('annee_debut')
            ->get();

        return view('candidat.profile', compact(
            'candidat', 'cvs', 'principalCv', 'competences',
            'steps', 'completion', 'experiences', 'formations'
        ));
    }

    public function showFeed()
    {
        $candidat = Auth::guard('candidat')->user();
        $offres = \App\Models\Offre::with('entreprise')
            ->where('statut_offre', 'active')
            ->orderByDesc('date_publication')
            ->get();

        // Load existing compatibility scores for the candidate
        $existingScores = Score::where('id_candidat', $candidat->id_candidat)
            ->pluck('score_compatibilite', 'id_offre')
            ->toArray();

        // Calculate scores only for offers without recent scores (older than 24 hours)
        $scoresToCalculate = $offres->filter(function($offre) use ($existingScores) {
            return !isset($existingScores[$offre->id_offre]);
        });

        // Batch calculate missing scores (limit to prevent timeout)
        $scoresToCalculate = $scoresToCalculate->take(20);
        
        foreach ($scoresToCalculate as $offre) {
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
            
            $existingScores[$offre->id_offre] = $matchResult['score_compatibilite'];
        }

        return view('candidat.feed', compact('candidat', 'offres'))->with('scores', $existingScores);
    }

    public function updateProfile(Request $request)
    {
        $candidat = Auth::guard('candidat')->user();

        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:50',
            'ville' => 'required|string|max:255',
            'niveau_etudes' => 'required|string|in:Bac,Licence+2,Licence,Master,Doctorat',
            'annees_experience' => 'required|integer|min:0|max:50',
            'competences' => 'nullable|string|max:500',
            'photo_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('photo_profil')) {
            $path = $request->file('photo_profil')->store('candidats/photos', 'public');
            $candidat->photo_profil = $path;
        }

        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $path = $file->store('candidats/cvs', 'public');
            
            // Marquer tous les CVs existants comme non principaux
            \App\Models\Cv::where('id_candidat', $candidat->id_candidat)->update(['est_principal' => false]);
            
            // Créer un nouveau CV
            \App\Models\Cv::create([
                'id_candidat' => $candidat->id_candidat,
                'nom_fichier' => $file->getClientOriginalName(),
                'contenu_fichier' => $path,
                'type_mime' => $file->getMimeType(),
                'taille_fichier' => $file->getSize(),
                'est_principal' => true,
                'date_upload' => now(),
                'statut' => 'actif',
            ]);
        }

        $candidat->prenom = $request->input('prenom');
        $candidat->nom = $request->input('nom');
        $candidat->telephone = $request->input('telephone');
        $candidat->ville = $request->input('ville');
        $candidat->niveau_etudes = $request->input('niveau_etudes');
        $candidat->annees_experience = $request->input('annees_experience');
        
        // Log pour débogage
        \Log::info('Competences reçues: ' . $request->input('competences'));
        
        $candidat->competences = $request->input('competences') ? implode(', ', array_filter(array_map('trim', explode(',', $request->input('competences'))))) : '';
        
        // Log pour débogage
        \Log::info('Competences sauvegardées: ' . $candidat->competences);
        
        $candidat->save();

        // Invalidate cached scores for this candidate - they will be recalculated on next feed view
        Score::where('id_candidat', $candidat->id_candidat)->delete();

        return redirect()->route('candidat.profil')->with('success', 'Profil mis à jour avec succès.');
    }

    public function showCandidatureEnvoyee()
    {
        $candidat = Auth::guard('candidat')->user();
        
        // Récupérer les données de la session si disponibles
        $titre_offre         = session('titre_offre');
        $nom_entreprise      = session('nom_entreprise');
        $id_offre            = session('id_offre');
        $score_final         = session('score_final');
        $score_compatibilite = session('score_compatibilite');
        $score_questionnaire = session('score_questionnaire');
        
        // Nettoyer la session
        session()->forget(['titre_offre', 'nom_entreprise', 'id_offre', 'score_final', 'score_compatibilite', 'score_questionnaire']);
        
        return view('candidat.candidature-envoyee', compact(
            'candidat', 'titre_offre', 'nom_entreprise', 'id_offre',
            'score_final', 'score_compatibilite', 'score_questionnaire'
        ));
    }
}
