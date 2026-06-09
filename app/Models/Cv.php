<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $table = 'cvs';
    protected $primaryKey = 'id_cv';

    protected $fillable = [
        'id_candidat',
        'nom_fichier',
        'contenu_fichier',
        'type_mime',
        'taille_fichier',
        'est_principal',
        'date_upload',
        'statut',
    ];

    protected $casts = [
        'est_principal' => 'boolean',
        'date_upload' => 'datetime',
        'taille_fichier' => 'integer',
    ];

    // Relations
    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id_candidat');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_cv', 'id_cv');
    }
}
