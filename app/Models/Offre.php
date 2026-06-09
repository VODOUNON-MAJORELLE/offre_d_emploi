<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $primaryKey = 'id_offre';

    protected $fillable = [
        'id_entreprise', 'titre_offre', 'description_offre',
        'competences_requises', 'niveau_etudes_requis', 'experience_requise',
        'type_contrat', 'salaire_min', 'salaire_max', 'ville_poste',
        'date_limite', 'date_publication', 'statut_offre', 'nb_candidatures',
    ];

    public function entreprise() {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }

    public function questionnaire() {
        return $this->hasOne(Questionnaire::class, 'id_offre', 'id_offre');
    }

    public function etapes() {
        return $this->hasMany(EtapeOffre::class, 'id_offre', 'id_offre');
    }
}