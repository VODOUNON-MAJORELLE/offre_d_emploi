<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    protected $table = 'questionnaires';
    protected $primaryKey = 'id_questionnaire';

    protected $fillable = [
        'id_offre',
        'titre_questionnaire',
    ];

    // Relations
    public function offre()
    {
        return $this->belongsTo(Offre::class, 'id_offre', 'id_offre');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'id_questionnaire', 'id_questionnaire');
    }
}
