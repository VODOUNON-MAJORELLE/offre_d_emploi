<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressionCandidature extends Model
{
    protected $table = 'progression_candidatures';
    protected $primaryKey = 'id_progression';

    protected $fillable = [
        'id_candidature',
        'id_etape_offre',
        'statut_etape', // en attente, en cours, complétée
        'declenchement', // automatique, manuel
        'date_validation',
    ];

    protected $casts = [
        'date_validation' => 'datetime',
    ];

    // Relations
    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'id_candidature', 'id_candidature');
    }

    public function etapeOffre()
    {
        return $this->belongsTo(EtapeOffre::class, 'id_etape_offre', 'id_etape_offre');
    }
}
