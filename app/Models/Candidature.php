<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    protected $table = 'candidatures';
    protected $primaryKey = 'id_candidature';

    protected $fillable = [
        'id_candidat',
        'id_offre',
        'id_cv',
        'lettre_motivation',
        'nom_lettre',
        'type_mime_lettre',
        'taille_lettre',
        'date_soumission',
        'note_interne',
        'motif_refus',
        'score_questionnaire',
        'score_final',
    ];

    protected $casts = [
        'date_soumission' => 'datetime',
        'score_questionnaire' => 'integer',
        'score_final' => 'integer',
        'taille_lettre' => 'integer',
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

    public function cv()
    {
        return $this->belongsTo(Cv::class, 'id_cv', 'id_cv');
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'id_candidature', 'id_candidature');
    }

    public function progressions()
    {
        return $this->hasMany(ProgressionCandidature::class, 'id_candidature', 'id_candidature');
    }

    public function avis()
    {
        return $this->hasOne(Avis::class, 'id_candidature', 'id_candidature');
    }
}
