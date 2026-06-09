<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';
    protected $primaryKey = 'id_score';

    protected $fillable = [
        'id_candidat',
        'id_offre',
        'score_competences',
        'score_experience',
        'score_etudes',
        'score_localisation',
        'score_compatibilite',
        'date_calcul',
    ];

    protected $casts = [
        'score_competences' => 'integer',
        'score_experience' => 'integer',
        'score_etudes' => 'integer',
        'score_localisation' => 'integer',
        'score_compatibilite' => 'integer',
        'date_calcul' => 'datetime',
    ];

    // Relations
    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id_candidat');
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class, 'id_offre', 'id_offre');
    }
}
