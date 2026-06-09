<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $table = 'offres';
    protected $primaryKey = 'id_offre';

    protected $fillable = [
        'id_entreprise',
        'titre_offre',
        'description_offre',
        'competences_requises',
        'questions_json',
        'niveau_etudes_requis',
        'experience_requise',
        'type_contrat',
        'teletravail',
        'salaire_min',
        'salaire_max',
        'devise',
        'ville_poste',
        'pays',
        'date_limite',
        'date_publication',
        'statut_offre',
        'nb_candidatures',
        'motif_moderation',
        'date_moderation',
        'moderee_par',
    ];

    protected $casts = [
        'date_limite' => 'datetime',
        'date_publication' => 'datetime',
        'date_moderation' => 'datetime',
        'experience_requise' => 'integer',
        'salaire_min' => 'integer',
        'salaire_max' => 'integer',
        'nb_candidatures' => 'integer',
        'questions_json' => 'array',
    ];

    // Relations
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_offre', 'id_offre');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'id_offre', 'id_offre');
    }

    public function questionnaire()
    {
        return $this->hasOne(Questionnaire::class, 'id_offre', 'id_offre');
    }

    public function etapes()
    {
        return $this->hasMany(EtapeOffre::class, 'id_offre', 'id_offre')->orderBy('ordre_etape', 'asc');
    }
}
