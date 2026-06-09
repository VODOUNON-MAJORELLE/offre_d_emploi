<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Candidat extends Authenticatable
{
    use Notifiable;

    protected $table = 'candidats';
    protected $primaryKey = 'id_candidat';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'statut_compte',
        'email_verifie',
        'token_verification',
        'date_inscription',
        'derniere_connexion',
        'token_reset',
        'expiration_token',
        'telephone',
        'ville',
        'niveau_etudes',
        'annees_experience',
        'competences',
        'photo_profil',
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
        'annees_experience' => 'integer',
    ];

    /**
     * Override standard password field for Laravel Auth.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // Relations
    public function cvs()
    {
        return $this->hasMany(Cv::class, 'id_candidat', 'id_candidat');
    }

    public function principalCv()
    {
        return $this->hasOne(Cv::class, 'id_candidat', 'id_candidat')->where('est_principal', true);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_candidat', 'id_candidat');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'id_candidat', 'id_candidat');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_candidat', 'id_candidat');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'id_candidat', 'id_candidat');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_candidat', 'id_candidat');
    }
}
