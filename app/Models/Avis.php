<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $table = 'avis';
    protected $primaryKey = 'id_avis';

    protected $fillable = [
        'id_candidat',
        'id_entreprise',
        'id_candidature',
        'note_globale',
        'commentaire',
        'note_clarte_offre',
        'note_qualite_retours',
        'note_respect_processus',
        'note_professionnalisme',
        'date_avis',
        'statut_avis',
        'motif_moderation',
        'date_moderation',
        'moderee_par',
    ];

    protected $casts = [
        'note_globale' => 'integer',
        'note_clarte_offre' => 'integer',
        'note_qualite_retours' => 'integer',
        'note_respect_processus' => 'integer',
        'note_professionnalisme' => 'integer',
        'date_avis' => 'datetime',
        'date_moderation' => 'datetime',
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

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'id_candidature', 'id_candidature');
    }
}
