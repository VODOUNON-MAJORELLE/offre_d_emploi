<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtapeOffre extends Model
{
    protected $table = 'etapes_offres';
    protected $primaryKey = 'id_etape_offre';

    protected $fillable = [
        'id_offre',
        'nom_etape',
        'ordre_etape',
        'est_obligatoire',
    ];

    protected $casts = [
        'ordre_etape' => 'integer',
        'est_obligatoire' => 'boolean',
    ];

    // Relations
    public function offre()
    {
        return $this->belongsTo(Offre::class, 'id_offre', 'id_offre');
    }

    public function progressions()
    {
        return $this->hasMany(ProgressionCandidature::class, 'id_etape_offre', 'id_etape_offre');
    }
}
