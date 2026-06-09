<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EntrepriseAuthController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\EtapeOffreController;
use App\Http\Controllers\ProgressionCandidatureController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;

// ── Page d'accueil ───────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ══════════════════════════════════════════════════════════════
// AUTHENTIFICATION ENTREPRISE
// ══════════════════════════════════════════════════════════════
Route::prefix('entreprise')->name('entreprise.')->group(function () {

    // Routes publiques (non connecté)
    Route::middleware('guest.entreprise')->group(function () {
        Route::get('/inscription',         [EntrepriseAuthController::class, 'showInscriptionEtape1'])->name('inscription.etape1');
        Route::post('/inscription',        [EntrepriseAuthController::class, 'storeEtape1'])->name('inscription.etape1.store');
        Route::get('/inscription/etape2',  [EntrepriseAuthController::class, 'showInscriptionEtape2'])->name('inscription.etape2');
        Route::post('/inscription/etape2', [EntrepriseAuthController::class, 'storeEtape2'])->name('inscription.etape2.store');
        Route::get('/login',               [EntrepriseAuthController::class, 'showLogin'])->name('login');
        Route::post('/login',              [EntrepriseAuthController::class, 'login'])->name('login.store');
        Route::get('/reset-password',      [EntrepriseAuthController::class, 'showResetPassword'])->name('reset.password');
        Route::post('/reset-password',     [EntrepriseAuthController::class, 'sendResetLink'])->name('reset.password.send');
        Route::get('/reset-password/{token}',  [EntrepriseAuthController::class, 'showNouveauMotDePasse'])->name('reset.password.form');
        Route::post('/reset-password/{token}', [EntrepriseAuthController::class, 'updateMotDePasse'])->name('reset.password.update');
        Route::get('/verify/{token}',      [EntrepriseAuthController::class, 'verifierEmail'])->name('verify');
    });

    // Routes protégées (connecté)
    Route::middleware('auth.entreprise')->group(function () {
        Route::post('/logout',             [EntrepriseAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard',           [EntrepriseController::class, 'dashboard'])->name('dashboard');

        // Profil
        Route::get('/profil',              [EntrepriseController::class, 'profil'])->name('profil');
        Route::put('/profil',              [EntrepriseController::class, 'updateProfil'])->name('profil.update');

        // Offres
        Route::get('/offres',              [OffreController::class, 'index'])->name('offres.index');
        Route::get('/offres/creer',        [OffreController::class, 'create'])->name('offres.create');
        Route::post('/offres',             [OffreController::class, 'store'])->name('offres.store');
        Route::get('/offres/{id}',         [OffreController::class, 'show'])->name('offres.show');
        Route::get('/offres/{id}/editer',  [OffreController::class, 'edit'])->name('offres.edit');
        Route::put('/offres/{id}',         [OffreController::class, 'update'])->name('offres.update');
        Route::patch('/offres/{id}/statut',[OffreController::class, 'changerStatut'])->name('offres.statut');

        // Questionnaire
        Route::get('/offres/{id}/questionnaire/creer',   [QuestionnaireController::class, 'create'])->name('questionnaire.create');
        Route::post('/offres/{id}/questionnaire',        [QuestionnaireController::class, 'store'])->name('questionnaire.store');
        Route::get('/questionnaire/{id}/editer',         [QuestionnaireController::class, 'edit'])->name('questionnaire.edit');
        Route::put('/questionnaire/{id}',                [QuestionnaireController::class, 'update'])->name('questionnaire.update');

        // Questions
        Route::post('/questionnaire/{id}/questions',          [QuestionController::class, 'store'])->name('question.store');
        Route::put('/questions/{id}',                         [QuestionController::class, 'update'])->name('question.update');
        Route::delete('/questions/{id}',                      [QuestionController::class, 'destroy'])->name('question.destroy');

        // Étapes recrutement
        Route::post('/offres/{id}/etapes',       [EtapeOffreController::class, 'store'])->name('etapes.store');
        Route::put('/etapes/{id}',               [EtapeOffreController::class, 'update'])->name('etapes.update');
        Route::delete('/etapes/{id}',            [EtapeOffreController::class, 'destroy'])->name('etapes.destroy');

        // Candidatures
        Route::get('/candidatures',              [ProgressionCandidatureController::class, 'index'])->name('candidatures.index');
        Route::get('/candidatures/{id}',         [ProgressionCandidatureController::class, 'show'])->name('candidatures.show');
        Route::patch('/candidatures/{id}/avancer', [ProgressionCandidatureController::class, 'avancer'])->name('candidatures.avancer');
        Route::patch('/candidatures/{id}/refuser', [ProgressionCandidatureController::class, 'refuser'])->name('candidatures.refuser');
        Route::patch('/candidatures/{id}/note',    [ProgressionCandidatureController::class, 'ajouterNote'])->name('candidatures.note');

        // Messagerie
        Route::get('/messages',              [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{id}',         [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages',             [MessageController::class, 'store'])->name('messages.store');

        // Notifications
        Route::get('/notifications',         [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/notifications/{id}/lire', [NotificationController::class, 'marquerLu'])->name('notifications.lire');
        Route::patch('/notifications/lire-tout', [NotificationController::class, 'marquerToutLu'])->name('notifications.lire.tout');
    });
});

// ══════════════════════════════════════════════════════════════
// ADMINISTRATION
// ══════════════════════════════════════════════════════════════
Route::prefix('admin')->name('admin.')->group(function () {

    // Routes publiques admin
    Route::middleware('guest.admin')->group(function () {
        Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
    });

    // Routes protégées admin
    Route::middleware('auth.admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Modération offres
        Route::get('/offres',              [AdminController::class, 'offres'])->name('offres');
        Route::patch('/offres/{id}/valider', [AdminController::class, 'validerOffre'])->name('offres.valider');
        Route::patch('/offres/{id}/rejeter', [AdminController::class, 'rejeterOffre'])->name('offres.rejeter');

        // Modération avis
        Route::get('/avis',              [AdminController::class, 'avis'])->name('avis');
        Route::delete('/avis/{id}',      [AdminController::class, 'supprimerAvis'])->name('avis.supprimer');

        // Gestion comptes
        Route::get('/comptes',                       [AdminController::class, 'comptes'])->name('comptes');
        Route::patch('/comptes/{type}/{id}/suspendre', [AdminController::class, 'suspendreCompte'])->name('comptes.suspendre');
        Route::patch('/comptes/{type}/{id}/reactiver', [AdminController::class, 'reactiverCompte'])->name('comptes.reactiver');
        Route::delete('/comptes/{type}/{id}',          [AdminController::class, 'supprimerCompte'])->name('comptes.supprimer');
    });
});