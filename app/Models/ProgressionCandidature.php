<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressionCandidature extends Model
{
    protected $primaryKey = 'id_progression';

    protected $fillable = [
        'id_candidature', 'id_etape_offre', 'statut_etape',
        'declenchement', 'date_validation'
    ];

    public function etape() {
        return $this->belongsTo(EtapeOffre::class, 'id_etape_offre', 'id_etape_offre');
    }
}