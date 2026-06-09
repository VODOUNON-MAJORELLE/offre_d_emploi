<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EntrepriseAuthController extends Controller
{
    // Afficher formulaire inscription étape 1
    public function showInscriptionEtape1()
    {
        return view('auth.entreprise.inscription_etape1');
    }

    // Traiter étape 1
    public function storeEtape1(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'secteur_activite' => 'required|string|max:255',
            'ville_entreprise' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Stocker en session
        session([
            'inscription_etape1' => $request->only([
                'nom_entreprise', 'secteur_activite',
                'ville_entreprise', 'description'
            ])
        ]);

        return redirect()->route('entreprise.inscription.etape2');
    }

    // Afficher formulaire inscription étape 2
    public function showInscriptionEtape2()
    {
        if (!session('inscription_etape1')) {
            return redirect()->route('entreprise.inscription.etape1');
        }
        return view('auth.entreprise.inscription_etape2');
    }

    // Traiter étape 2 et créer le compte
    public function storeEtape2(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:entreprises,email',
            'telephone' => 'nullable|string|max:20',
            'mot_de_passe' => 'required|min:8|confirmed',
            'logo' => 'nullable|image|max:2048',
        ]);

        $etape1 = session('inscription_etape1');

        // Upload logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Token vérification email
        $token = Str::random(64);

        // Créer l'entreprise
        $entreprise = Entreprise::create([
            'nom_entreprise'   => $etape1['nom_entreprise'],
            'secteur_activite' => $etape1['secteur_activite'],
            'ville_entreprise' => $etape1['ville_entreprise'],
            'description'      => $etape1['description'],
            'email'            => $request->email,
            'telephone'        => $request->telephone,
            'mot_de_passe'     => Hash::make($request->mot_de_passe),
            'logo'             => $logoPath,
            'token_verification' => $token,
            'email_verifie'    => false,
            'statut_compte'    => 'en_attente',
        ]);

        // Envoyer email de vérification
        Mail::send('emails.verification', ['token' => $token, 'entreprise' => $entreprise], function ($mail) use ($entreprise) {
            $mail->to($entreprise->email)
                 ->subject('Vérifiez votre adresse email - JobConnect');
        });

        session()->forget('inscription_etape1');

        return redirect()->route('entreprise.login')
            ->with('success', 'Compte créé ! Vérifiez votre email avant de vous connecter.');
    }

    // Vérifier l'email
    public function verifierEmail($token)
    {
        $entreprise = Entreprise::where('token_verification', $token)->first();

        if (!$entreprise) {
            return redirect()->route('entreprise.login')
                ->with('error', 'Lien de vérification invalide.');
        }

        $entreprise->update([
            'email_verifie' => true,
            'token_verification' => null,
            'statut_compte' => 'actif',
        ]);

        return redirect()->route('entreprise.login')
            ->with('success', 'Email vérifié ! Vous pouvez maintenant vous connecter.');
    }

    // Afficher formulaire connexion
    public function showLogin()
    {
        return view('auth.entreprise.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        $entreprise = Entreprise::where('email', $request->email)->first();

        if (!$entreprise || !Hash::check($request->mot_de_passe, $entreprise->mot_de_passe)) {
            return back()->with('error', 'Email ou mot de passe incorrect.');
        }

        if (!$entreprise->email_verifie) {
            return back()->with('error', 'Veuillez vérifier votre email avant de vous connecter.');
        }

        if ($entreprise->statut_compte === 'suspendu') {
            return back()->with('error', 'Votre compte a été suspendu.');
        }

        // Connecter l'entreprise en session
        session(['entreprise_id' => $entreprise->id_entreprise, 'entreprise' => $entreprise]);
        $entreprise->update(['derniere_connexion' => now()]);

        return redirect()->route('entreprise.dashboard')
            ->with('success', 'Bienvenue ' . $entreprise->nom_entreprise . ' !');
    }

    // Déconnexion
    public function logout()
    {
        session()->forget(['entreprise_id', 'entreprise']);
        return redirect()->route('entreprise.login')
            ->with('success', 'Vous êtes déconnecté.');
    }

    // Afficher formulaire reset password
    public function showResetPassword()
    {
        return view('auth.entreprise.reset_password');
    }

    // Envoyer lien reset
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $entreprise = Entreprise::where('email', $request->email)->first();

        if (!$entreprise) {
            return back()->with('error', 'Aucun compte trouvé avec cet email.');
        }

        $token = Str::random(64);
        $entreprise->update([
            'token_reset' => $token,
            'expiration_token' => now()->addMinutes(30),
        ]);

        Mail::send('emails.reset_password', ['token' => $token, 'entreprise' => $entreprise], function ($mail) use ($entreprise) {
            $mail->to($entreprise->email)
                 ->subject('Réinitialisation de votre mot de passe - JobConnect');
        });

        return back()->with('success', 'Lien de réinitialisation envoyé à votre email.');
    }

    // Afficher formulaire nouveau mot de passe
    public function showNouveauMotDePasse($token)
    {
        $entreprise = Entreprise::where('token_reset', $token)
            ->where('expiration_token', '>', now())
            ->first();

        if (!$entreprise) {
            return redirect()->route('entreprise.login')
                ->with('error', 'Lien expiré ou invalide.');
        }

        return view('auth.entreprise.nouveau_mot_de_passe', compact('token'));
    }

    // Enregistrer nouveau mot de passe
    public function updateMotDePasse(Request $request, $token)
    {
        $request->validate([
            'mot_de_passe' => 'required|min:8|confirmed',
        ]);

        $entreprise = Entreprise::where('token_reset', $token)
            ->where('expiration_token', '>', now())
            ->first();

        if (!$entreprise) {
            return redirect()->route('entreprise.login')
                ->with('error', 'Lien expiré ou invalide.');
        }

        $entreprise->update([
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'token_reset' => null,
            'expiration_token' => null,
        ]);

        return redirect()->route('entreprise.login')
            ->with('success', 'Mot de passe mis à jour avec succès !');
    }
}