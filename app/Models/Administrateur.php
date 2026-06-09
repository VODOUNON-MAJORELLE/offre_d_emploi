<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'administrateurs';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'date_inscription',
        'derniere_connexion',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
        'derniere_connexion' => 'datetime',
    ];

    /**
     * Override standard password field for Laravel Auth.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // Relations
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_admin', 'id_admin');
    }
}
