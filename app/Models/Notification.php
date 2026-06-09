<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id_notification';

    protected $fillable = [
        'id_candidat',
        'id_entreprise',
        'id_admin',
        'titre_notification',
        'contenu_notification',
        'type_notification',
        'id_reference',
        'type_reference',
        'date_envoi',
        'statut_lecture',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
        'id_reference' => 'integer',
    ];

    // Relations
    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id_candidat');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }

    public function admin()
    {
        return $this->belongsTo(Administrateur::class, 'id_admin', 'id_admin');
    }
}
