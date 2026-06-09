<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaEntreprise extends Model
{
    use HasFactory;

    protected $table = 'media_entreprises';
    protected $primaryKey = 'id_media';

    protected $fillable = [
        'id_entreprise',
        'titre',
        'categorie',
        'chemin_fichier',
        'type_mime',
        'taille_fichier',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }
}
