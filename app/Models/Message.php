<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id_message';

    protected $fillable = [
        'id_candidat',
        'id_entreprise',
        'contenu_message',
        'date_envoi',
        'statut_lecture',
        'sender_type',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
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
}
