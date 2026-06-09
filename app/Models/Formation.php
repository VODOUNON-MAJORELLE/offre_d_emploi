<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $table = 'formations';
    protected $primaryKey = 'id_formation';

    protected $fillable = [
        'id_candidat',
        'diplome',
        'etablissement',
        'annee_debut',
        'annee_fin',
        'description',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id_candidat');
    }

    public function getPeriodeAttribute(): string
    {
        return $this->annee_debut . ' – ' . ($this->annee_fin ?? 'Présent');
    }
}
