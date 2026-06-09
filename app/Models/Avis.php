<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $primaryKey = 'id_avis';

    protected $fillable = [
        'id_candidat', 'id_entreprise', 'id_candidature',
        'note_globale', 'commentaire', 'note_clarte_offre',
        'note_qualite_retours', 'note_respect_processus',
        'note_professionnalisme', 'date_avis', 'statut_avis'
    ];

    public function entreprise() {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }
}