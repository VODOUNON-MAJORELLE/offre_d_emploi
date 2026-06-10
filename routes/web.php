<?php

use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ProgressionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Feed public - liste des offres sans possibilité de postuler
Route::get('/feed/public', function () {
    $offres = \App\Models\Offre::where('statut_offre', 'active')
        ->orderByDesc('date_publication')
        ->get();
    return view('feed', compact('offres'));
})->name('feed.public');

// Auth routes (login unique)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
Route::get('/login/admin', function() {
    return view('auth.login-admin');
})->name('login.admin');

// Registration routes
Route::get('/register/candidat', [AuthController::class, 'showCandidatRegisterForm'])->name('register.candidat');
Route::post('/register/candidat', [AuthController::class, 'registerCandidat'])->name('register.candidat.submit');
Route::get('/register/entreprise', [AuthController::class, 'showEntrepriseRegisterForm'])->name('register.entreprise');
Route::post('/register/entreprise', [AuthController::class, 'registerEntreprise'])->name('register.entreprise.submit');

// Admin routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ── Modération des offres ──
    Route::get('/offres',                    [AdminController::class, 'offres'])->name('offres');
    Route::post('/offres/{id}/valider',      [AdminController::class, 'validerOffre'])->name('offres.valider');
    Route::post('/offres/{id}/rejeter',      [AdminController::class, 'rejeterOffre'])->name('offres.rejeter');
    Route::post('/offres/{id}/avertir',      [AdminController::class, 'avertirOffre'])->name('offres.avertir');

    // ── Modération des avis ──
    Route::get('/avis',                      [AdminController::class, 'avis'])->name('avis');
    Route::post('/avis/{id}/supprimer',      [AdminController::class, 'supprimerAvis'])->name('avis.supprimer');
    Route::post('/avis/{id}/avertir',        [AdminController::class, 'avertirAvis'])->name('avis.avertir');
    Route::post('/avis/{id}/restaurer',      [AdminController::class, 'restaurerAvis'])->name('avis.restaurer');

    // ── Gestion des candidats ──
    Route::get('/candidats',                 [AdminController::class, 'candidats'])->name('candidats');
    Route::post('/candidats/{id}/suspendre', [AdminController::class, 'suspendreCandidat'])->name('candidats.suspendre');
    Route::post('/candidats/{id}/supprimer', [AdminController::class, 'supprimerCandidat'])->name('candidats.supprimer');
    Route::post('/candidats/{id}/reactiver', [AdminController::class, 'reactiverCandidat'])->name('candidats.reactiver');

    // ── Gestion des entreprises ──
    Route::get('/entreprises',                   [AdminController::class, 'entreprises'])->name('entreprises');
    Route::post('/entreprises/{id}/suspendre',   [AdminController::class, 'suspendreEntreprise'])->name('entreprises.suspendre');
    Route::post('/entreprises/{id}/supprimer',   [AdminController::class, 'supprimerEntreprise'])->name('entreprises.supprimer');
    Route::post('/entreprises/{id}/reactiver',   [AdminController::class, 'reactiverEntreprise'])->name('entreprises.reactiver');
});


// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

// Candidate routes protected by auth:candidat & check_status
Route::middleware(['auth:candidat', 'check_status'])->group(function () {
    // Feed candidat — liste des offres
    Route::get('/feed', [\App\Http\Controllers\CandidatController::class, 'showFeed'])->name('candidat.feed');

    // Dashboard candidat — suivi de toutes les candidatures
    Route::get('/candidat/dashboard', function () {
        $candidat = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
        $candidatures = \App\Models\Candidature::with([
            'offre.entreprise',
            'progressions.etapeOffre',
            'avis',
            'candidat.scores'
        ])
            ->where('id_candidat', $candidat->id_candidat)
            ->orderByDesc('date_soumission')
            ->get();
        return view('candidat.dashboard', compact('candidatures'));
    })->name('candidat.dashboard');

    // Profil candidat
    Route::get('/candidat/profil', [\App\Http\Controllers\CandidatController::class, 'showProfile'])->name('candidat.profil');
    Route::post('/candidat/profil', [\App\Http\Controllers\CandidatController::class, 'updateProfile'])->name('candidat.profil.update');

    Route::get('/offres/{id_offre}/postuler', [CandidatureController::class, 'showApplyForm'])->name('candidat.offres.postuler');
    Route::post('/offres/{id_offre}/postuler', [CandidatureController::class, 'store'])->name('candidat.offres.submit');
    
    // Supprimer une candidature
    Route::delete('/candidatures/{id_candidature}', [CandidatureController::class, 'destroy'])->name('candidat.candidatures.delete');
    
    // Candidature envoyée (confirmation)
    Route::get('/candidature/envoyee', [\App\Http\Controllers\CandidatController::class, 'showCandidatureEnvoyee'])->name('candidat.candidature.envoyee');
    
    // Candidature detail (Avancement)
    Route::get('/candidatures/{id_candidature}/avancement', function ($id_candidature) {
        $candidat = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
        $candidature = \App\Models\Candidature::with(['offre.entreprise', 'offre.etapes', 'progressions.etapeOffre'])
            ->where('id_candidat', $candidat->id_candidat)
            ->findOrFail($id_candidature);
        return view('candidat.candidature_avancement', compact('candidature'));
    })->name('candidat.candidatures.show');
    // Soumettre un avis
    Route::post('/entreprises/{id_entreprise}/avis', [AvisController::class, 'store'])->name('candidat.avis.store');
    // Modifier un avis
    Route::post('/avis/{id_avis}', [AvisController::class, 'update'])->name('candidat.avis.update');
    // Supprimer un avis
    Route::delete('/avis/{id_avis}', [AvisController::class, 'destroy'])->name('candidat.avis.destroy');

    // Vue profil entreprise (côté candidat)
    Route::get('/entreprise/{id_entreprise}/voir', function ($id_entreprise) {
        $entreprise = \App\Models\Entreprise::findOrFail($id_entreprise);
        return view('entreprise.profil', compact('entreprise'));
    })->name('candidat.entreprise.profil');

    // Expériences candidat
    Route::post('/candidat/experiences', [\App\Http\Controllers\ProfilController::class, 'storeExperience'])->name('candidat.experiences.store');
    Route::delete('/candidat/experiences/{id}', [\App\Http\Controllers\ProfilController::class, 'destroyExperience'])->name('candidat.experiences.destroy');

    // Formations candidat
    Route::post('/candidat/formations', [\App\Http\Controllers\ProfilController::class, 'storeFormation'])->name('candidat.formations.store');
    Route::delete('/candidat/formations/{id}', [\App\Http\Controllers\ProfilController::class, 'destroyFormation'])->name('candidat.formations.destroy');

});

// Company routes protected by auth:entreprise & check_status
Route::middleware(['auth:entreprise', 'check_status'])->group(function () {
    // Dashboard entreprise
    Route::get('/entreprise/dashboard', function () {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        return view('entreprise.dashboard', compact('entreprise'));
    })->name('entreprise.dashboard');

    // Profil entreprise
    Route::get('/entreprise/profil', function () {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        return view('entreprise.profil', compact('entreprise'));
    })->name('entreprise.profil');
    Route::post('/entreprise/profil', function (\Illuminate\Http\Request $request) {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        $request->validate([
            'nom_entreprise' => 'nullable|string|max:255',
            'secteur_activite' => 'nullable|string|max:255',
            'ville_entreprise' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'telephone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        
        if ($request->has('nom_entreprise')) {
            $entreprise->nom_entreprise = $request->input('nom_entreprise');
        }
        if ($request->has('secteur_activite')) {
            $entreprise->secteur_activite = $request->input('secteur_activite');
        }
        if ($request->has('ville_entreprise')) {
            $entreprise->ville_entreprise = $request->input('ville_entreprise');
        }
        if ($request->has('description')) {
            $entreprise->description = $request->input('description');
        }
        if ($request->has('telephone')) {
            $entreprise->telephone = $request->input('telephone');
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('logos', 'public');
            $entreprise->logo = $path;
        }
        
        $entreprise->save();
        return redirect()->route('entreprise.profil')->with('success', 'Profil mis à jour avec succès.');
    })->name('entreprise.profil.update');

    // Profil entreprise public (accessible aux candidats)
    Route::get('/entreprises/{id_entreprise}', function ($id_entreprise) {
        $entreprise = \App\Models\Entreprise::findOrFail($id_entreprise);
        return view('entreprise.profil', compact('entreprise'));
    })->name('entreprises.show');

    // Profil candidat public (accessible aux entreprises)
    Route::get('/candidats/{id_candidat}', function ($id_candidat) {
        $candidat = \App\Models\Candidat::findOrFail($id_candidat);
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
    })->name('candidats.show');

    // Créer une offre
    Route::get('/entreprise/offres/create', function () {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        return view('entreprise.offre-create', compact('entreprise'));
    })->name('entreprise.offres.create');

    // Liste des offres
    Route::get('/entreprise/offres', function () {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        return view('entreprise.offres', compact('entreprise'));
    })->name('entreprise.offres.index');

    // Stocker une offre
    Route::post('/entreprise/offres', [\App\Http\Controllers\OffreController::class, 'store'])->name('entreprise.offres.store');

    // Modifier une offre
    Route::get('/entreprise/offres/{id_offre}/edit', [\App\Http\Controllers\OffreController::class, 'edit'])->name('entreprise.offres.edit');
    Route::put('/entreprise/offres/{id_offre}', [\App\Http\Controllers\OffreController::class, 'update'])->name('entreprise.offres.update');

    // Suspendre une offre
    Route::post('/entreprise/offres/{id_offre}/suspendre', [\App\Http\Controllers\OffreController::class, 'suspend'])->name('entreprise.offres.suspend');

    // Clôturer une offre
    Route::post('/entreprise/offres/{id_offre}/cloturer', [\App\Http\Controllers\OffreController::class, 'close'])->name('entreprise.offres.close');

    // Réactiver une offre
    Route::post('/entreprise/offres/{id_offre}/reactiver', [\App\Http\Controllers\OffreController::class, 'reactivate'])->name('entreprise.offres.reactivate');

    // Détail d'une offre
    Route::get('/entreprise/offres/{id_offre}/detail', function ($id_offre) {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        $offre = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);
        return view('entreprise.offre-detail', compact('offre'));
    })->name('entreprise.offres.detail');

    // Détail d'une candidature
    Route::get('/entreprise/candidatures/{id_candidature}', function ($id_candidature) {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        $candidature = \App\Models\Candidature::with(['candidat', 'offre.questionnaire.questions.options', 'progressions.etapeOffre', 'reponses.question'])
            ->whereHas('offre', function($query) use ($entreprise) {
                $query->where('id_entreprise', $entreprise->id_entreprise);
            })
            ->findOrFail($id_candidature);
        return view('entreprise.candidature-detail', compact('candidature'));
    })->name('entreprise.candidatures.show');

    // Candidatures reçues par offre
    Route::get('/entreprise/offres/{id_offre}/candidatures', function ($id_offre) {
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        $offre = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->findOrFail($id_offre);
        $candidatures = \App\Models\Candidature::with([
            'candidat.scores',
            'progressions.etapeOffre',
            'offre.entreprise'
        ])
            ->where('id_offre', $id_offre)
            ->orderByDesc('score_final')
            ->get();
        return view('entreprise.candidatures.index', compact('offre', 'candidatures'));
    })->name('entreprise.offres.candidatures');

    Route::post('/candidatures/{id_candidature}/note', [CandidatureController::class, 'updateNote'])->name('entreprise.candidatures.note');
    Route::post('/candidatures/{id_candidature}/rejeter', [CandidatureController::class, 'reject'])->name('entreprise.candidatures.reject');

    Route::get('/offres/{id_offre}/questionnaire/creer', [QuestionnaireController::class, 'create'])->name('entreprise.questionnaires.create');
    Route::post('/offres/{id_offre}/questionnaire', [QuestionnaireController::class, 'store'])->name('entreprise.questionnaires.store');
    Route::post('/reponses/{id_reponse}/noter', [QuestionnaireController::class, 'gradeShortAnswer'])->name('entreprise.reponses.grade');

    Route::post('/candidatures/{id_candidature}/progression', [ProgressionController::class, 'advanceStep'])->name('entreprise.candidatures.progression');
    Route::post('/progressions/{id_progression}', [ProgressionController::class, 'updateStatus'])->name('entreprise.progressions.update');
});

// Shared download routes (both candidate and company can download CV/Letter)
Route::middleware(['check_status'])->group(function () {
    Route::get('/cv/{id_cv}/telecharger', [CandidatureController::class, 'downloadCv'])->name('cvs.download');
    Route::get('/candidature/{id_candidature}/lettre', [CandidatureController::class, 'downloadLettre'])->name('candidatures.downloadLettre');
    
    // Fallback GET route for /candidatures/{id_candidature} to prevent 405 Method Not Allowed
    Route::get('/candidatures/{id_candidature}', function ($id_candidature) {
        if (\Illuminate\Support\Facades\Auth::guard('candidat')->check()) {
            return redirect()->route('candidat.candidatures.show', ['id_candidature' => $id_candidature]);
        }
        if (\Illuminate\Support\Facades\Auth::guard('entreprise')->check()) {
            return redirect()->route('entreprise.candidatures.show', ['id_candidature' => $id_candidature]);
        }
        return redirect()->route('login');
    });

    // Messaging routes (accessible by candidate or company depending on auth guard)
    Route::get('/messagerie', [MessageController::class, 'index'])->name('messagerie.index');
    Route::get('/messagerie/{id_partner}', [MessageController::class, 'show'])->name('messagerie.show');
    Route::post('/messagerie/{id_partner}', [MessageController::class, 'store'])->name('messagerie.store');

    // Notifications routes
    Route::get('/notifications', function () {
        return view('notifications');
    })->name('notifications.index');
    Route::post('/notifications/{id_notification}/mark-read', function ($id_notification) {
        $notif = \App\Models\Notification::findOrFail($id_notification);
        $notif->statut_lecture = 'lu';
        $notif->save();
        return response()->json(['success' => true]);
    })->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', function () {
        $candidat = \Illuminate\Support\Facades\Auth::guard('candidat')->user();
        $entreprise = \Illuminate\Support\Facades\Auth::guard('entreprise')->user();
        
        \App\Models\Notification::where(function($query) use ($candidat, $entreprise) {
            if ($candidat) {
                $query->where('id_candidat', $candidat->id_candidat);
            } elseif ($entreprise) {
                $query->where('id_entreprise', $entreprise->id_entreprise);
            }
        })->update(['statut_lecture' => 'lu']);
        
        return response()->json(['success' => true]);
    })->name('notifications.mark-all-read');
});

// ---- AUTH PAGES ----
Route::get('/entreprise/login', function() {
    return redirect()->route('login');
})->name('entreprise.login');
Route::get('/admin/login', function() { return 'Admin Login Page'; })->name('admin.login');

// --- ROUTES DE TEST POUR L'ETUDIANT 2 ---
// Ces routes permettent de se connecter automatiquement pour tester les modules.
Route::get('/dev/login/candidat', function() {
    $candidat = \App\Models\Candidat::first();
    if (!$candidat) return 'Veuillez exécuter: php artisan db:seed';
    \Illuminate\Support\Facades\Auth::guard('candidat')->login($candidat);
    return redirect()->route('candidat.dashboard');
});

Route::get('/dev/login/entreprise', function() {
    $entreprise = \App\Models\Entreprise::first();
    if (!$entreprise) return 'Veuillez exécuter: php artisan db:seed';
    $offre = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->first();
    \Illuminate\Support\Facades\Auth::guard('entreprise')->login($entreprise);
    return redirect()->route('entreprise.offres.candidatures', ['id_offre' => $offre->id_offre]);
});

Route::get('/dev/postuler', function() {
    $candidat = \App\Models\Candidat::first();
    $offre = \App\Models\Offre::first();
    if (!$candidat || !$offre) return 'Veuillez exécuter: php artisan db:seed';
    \Illuminate\Support\Facades\Auth::guard('candidat')->login($candidat);
    return redirect()->route('candidat.offres.postuler', ['id_offre' => $offre->id_offre]);
});

Route::get('/dev/questionnaire', function() {
    $entreprise = \App\Models\Entreprise::first();
    $offre = \App\Models\Offre::where('id_entreprise', $entreprise->id_entreprise)->first();
    if (!$entreprise || !$offre) return 'Veuillez exécuter: php artisan db:seed';
    \Illuminate\Support\Facades\Auth::guard('entreprise')->login($entreprise);
    return redirect()->route('entreprise.questionnaires.create', ['id_offre' => $offre->id_offre]);
});

Route::get('/dev/login/admin', function() {
    $admin = \App\Models\Administrateur::first();
    if (!$admin) {
        $admin = new \App\Models\Administrateur();
        $admin->nom = 'Admin';
        $admin->prenom = 'Talentlink';
        $admin->email = 'admin@talentlink.com';
        $admin->mot_de_passe = \Illuminate\Support\Facades\Hash::make('password');
        $admin->save();
    }
    \Illuminate\Support\Facades\Auth::guard('admin')->login($admin);
    return redirect()->route('admin.dashboard');
});
