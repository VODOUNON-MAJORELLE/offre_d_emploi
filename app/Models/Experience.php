<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experiences';
    protected $primaryKey = 'id_experience';

    protected $fillable = [
        'id_candidat',
        'poste',
        'entreprise',
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
