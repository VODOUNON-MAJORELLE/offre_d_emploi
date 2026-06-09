<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications_jobconnect';
    protected $primaryKey = 'id_notification';

    protected $fillable = [
        'id_candidat', 'id_entreprise', 'id_admin',
        'titre_notification', 'contenu_notification', 'type_notification',
        'id_reference', 'type_reference', 'date_envoi', 'statut_lecture'
    ];

    public function entreprise() {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }
}