<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Entreprise extends Authenticatable
{
    use Notifiable;

    protected $table = 'entreprises';
    protected $primaryKey = 'id_entreprise';

    protected $fillable = [
        'nom_entreprise',
        'email',
        'mot_de_passe',
        'statut_compte',
        'email_verifie',
        'token_verification',
        'date_inscription',
        'derniere_connexion',
        'token_reset',
        'expiration_token',
        'secteur_activite',
        'ville_entreprise',
        'pays',
        'devise',
        'description',
        'valeurs',
        'telephone',
        'logo',
        'note_moyenne',
    ];

    protected $hidden = [
        'mot_de_passe',
        'token_verification',
        'token_reset',
    ];

    protected $casts = [
        'email_verifie' => 'boolean',
        'date_inscription' => 'datetime',
        'derniere_connexion' => 'datetime',
        'expiration_token' => 'datetime',
        'note_moyenne' => 'decimal:2',
    ];

    /**
     * Override standard password field for Laravel Auth.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // Relations
    public function offres()
    {
        return $this->hasMany(Offre::class, 'id_entreprise', 'id_entreprise');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_entreprise', 'id_entreprise');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'id_entreprise', 'id_entreprise');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_entreprise', 'id_entreprise');
    }
}
