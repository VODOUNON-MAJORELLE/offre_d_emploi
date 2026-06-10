<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showCandidatRegisterForm()
    {
        return view('auth.register-candidat');
    }

    public function showEntrepriseRegisterForm()
    {
        return view('auth.register-entreprise');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->has('remember');

        // Essayer admin d'abord
        $admin = \App\Models\Administrateur::where('email', $email)->first();
        if ($admin && \Illuminate\Support\Facades\Hash::check($password, $admin->mot_de_passe)) {
            Auth::guard('admin')->login($admin, $remember);
            return redirect()->intended(route('admin.dashboard'));
        }

        // Essayer candidat
        $candidat = \App\Models\Candidat::where('email', $email)->first();
        if ($candidat && \Illuminate\Support\Facades\Hash::check($password, $candidat->mot_de_passe)) {
            Auth::guard('candidat')->login($candidat, $remember);
            return redirect()->intended(route('candidat.feed'));
        }

        // Essayer entreprise
        $entreprise = \App\Models\Entreprise::where('email', $email)->first();
        if ($entreprise && \Illuminate\Support\Facades\Hash::check($password, $entreprise->mot_de_passe)) {
            Auth::guard('entreprise')->login($entreprise, $remember);
            return redirect()->intended(route('entreprise.dashboard'));
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Les identifiants sont incorrects.',
            ]);
    }

    public function registerCandidat(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:candidats,email|unique:entreprises,email',
            'telephone' => 'required|string|max:50',
            'ville' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'cgu' => 'accepted',
            'photo_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'cgu.accepted' => 'Vous devez accepter les CGU pour continuer.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
        ]);

        $candidat = new \App\Models\Candidat();
        $candidat->prenom = $request->input('prenom');
        $candidat->nom = $request->input('nom');
        $candidat->email = $request->input('email');
        $candidat->telephone = $request->input('telephone');
        $candidat->ville = $request->input('ville');
        $candidat->niveau_etudes = 'Licence'; // Valeur par défaut pour éviter l'erreur SQL
        $candidat->competences = ''; // Valeur par défaut pour éviter l'erreur SQL
        $candidat->mot_de_passe = \Illuminate\Support\Facades\Hash::make($request->input('password'));
        $candidat->statut_compte = 'actif';

        // Handle photo upload
        if ($request->hasFile('photo_profil')) {
            $path = $request->file('photo_profil')->store('candidats/photos', 'public');
            $candidat->photo_profil = $path;
        }

        $candidat->save();

        // Auto-login the new user
        Auth::guard('candidat')->login($candidat);

        return redirect()->route('candidat.feed')->with('success', 'Compte créé avec succès !');
    }

    public function registerEntreprise(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'ville_entreprise' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'devise' => 'required|string|max:10',
            'description' => 'nullable|string|max:2000',
            'email' => 'required|email|unique:candidats,email|unique:entreprises,email',
            'telephone' => 'required|string|max:50',
            'password' => 'required|string|min:6|confirmed',
            'cgu' => 'accepted',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ], [
            'cgu.accepted' => 'Vous devez accepter les CGU pour continuer.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
        ]);

        $entreprise = new \App\Models\Entreprise();
        $entreprise->nom_entreprise = $request->input('nom_entreprise');
        $entreprise->secteur_activite = $request->input('secteur'); // Correction de la propriété secteur -> secteur_activite
        $entreprise->ville_entreprise = $request->input('ville_entreprise');
        $entreprise->pays = $request->input('pays', 'Bénin');
        $entreprise->devise = $request->input('devise', 'FCFA');
        $entreprise->description = $request->input('description');
        $entreprise->email = $request->input('email');
        $entreprise->telephone = $request->input('telephone');
        $entreprise->mot_de_passe = \Illuminate\Support\Facades\Hash::make($request->input('password'));
        $entreprise->statut_compte = 'actif';

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('entreprises/logos', 'public');
            $entreprise->logo = $path;
        }

        $entreprise->save();

        // Auto-login the new user
        Auth::guard('entreprise')->login($entreprise);

        return redirect()->route('entreprise.dashboard')->with('success', 'Compte créé avec succès !');
    }

    public function logout(Request $request)
    {
        $guard = Auth::getDefaultDriver();
        
        if ($guard === 'candidat') {
            Auth::guard('candidat')->logout();
        } elseif ($guard === 'entreprise') {
            Auth::guard('entreprise')->logout();
        } elseif ($guard === 'admin') {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Vérifier si l'email existe dans candidat ou entreprise
        $candidat = \App\Models\Candidat::where('email', $email)->first();
        $entreprise = \App\Models\Entreprise::where('email', $email)->first();

        if (!$candidat && !$entreprise) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Aucun compte trouvé avec cette adresse email.',
                ]);
        }

        // Générer un token unique
        $token = \Illuminate\Support\Str::random(60);

        // Supprimer les anciens tokens pour cet email
        \App\Models\PasswordReset::where('email', $email)->delete();

        // Créer un nouveau token
        \App\Models\PasswordReset::create([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Envoyer l'email
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);
        
        \Illuminate\Support\Facades\Mail::send('emails.password-reset', [
            'resetUrl' => $resetUrl,
            'email' => $email,
        ], function ($message) use ($email) {
            $message->to($email)
                    ->subject('Réinitialisation de votre mot de passe - Talentlink');
        });

        return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
    }

    public function showResetPasswordForm(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed|regex:/[A-Z]/|regex:/[0-9]/',
        ], [
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule et un chiffre.',
        ]);

        $email = $request->input('email');
        $token = $request->input('token');
        $password = $request->input('password');

        // Vérifier si le token est valide
        $passwordReset = \App\Models\PasswordReset::where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Le lien de réinitialisation est invalide ou a expiré.',
                ]);
        }

        // Vérifier si le token n'a pas expiré (60 minutes)
        if ($passwordReset->created_at->lt(now()->subMinutes(60))) {
            $passwordReset->delete();
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Le lien de réinitialisation a expiré. Veuillez demander un nouveau lien.',
                ]);
        }

        // Vérifier si l'email existe dans candidat ou entreprise
        $candidat = \App\Models\Candidat::where('email', $email)->first();
        $entreprise = \App\Models\Entreprise::where('email', $email)->first();

        if (!$candidat && !$entreprise) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Aucun compte trouvé avec cette adresse email.',
                ]);
        }

        // Mettre à jour le mot de passe
        if ($candidat) {
            $candidat->mot_de_passe = \Illuminate\Support\Facades\Hash::make($password);
            $candidat->save();
        }

        if ($entreprise) {
            $entreprise->mot_de_passe = \Illuminate\Support\Facades\Hash::make($password);
            $entreprise->save();
        }

        // Supprimer le token utilisé
        $passwordReset->delete();

        return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé avec succès.');
    }
}
