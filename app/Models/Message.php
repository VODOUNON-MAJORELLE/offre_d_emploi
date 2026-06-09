<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'id_message';

    protected $fillable = [
        'id_candidature', 'id_candidat_expediteur', 'id_entreprise_expediteur',
        'id_candidat_destinataire', 'id_entreprise_destinataire',
        'contenu_message', 'date_envoi', 'statut_lecture'
    ];

    public function entrepriseExpediteur() {
        return $this->belongsTo(Entreprise::class, 'id_entreprise_expediteur', 'id_entreprise');
    }
}