<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Entreprise extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_entreprise';

    protected $fillable = [
        'nom_entreprise', 'email', 'mot_de_passe', 'secteur_activite',
        'ville_entreprise', 'description', 'telephone', 'logo',
        'note_moyenne', 'statut_compte', 'email_verifie',
        'token_verification', 'token_reset', 'expiration_token',
        'derniere_connexion',
    ];

    protected $hidden = ['mot_de_passe', 'token_reset', 'token_verification'];

    protected $casts = [
        'email_verifie' => 'boolean',
        'expiration_token' => 'datetime',
        'derniere_connexion' => 'datetime',
    ];

    // Indique à Laravel que le mot de passe s'appelle 'mot_de_passe'
    public function getAuthPasswordName(): string
    {
        return 'mot_de_passe';
    }

    public function offres() {
        return $this->hasMany(Offre::class, 'id_entreprise', 'id_entreprise');
    }

    public function avis() {
        return $this->hasMany(Avis::class, 'id_entreprise', 'id_entreprise');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'id_entreprise_expediteur', 'id_entreprise');
    }

    public function notifications() {
        return $this->hasMany(Notification::class, 'id_entreprise', 'id_entreprise');
    }
}