<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    protected $table = 'reponses';
    protected $primaryKey = 'id_reponse';

    protected $fillable = [
        'id_question',
        'id_candidature',
        'contenu_reponse',
        'est_correcte',
        'score_manuel',
        'score_reponse',
    ];

    protected $casts = [
        'est_correcte' => 'boolean',
        'score_manuel' => 'integer',
        'score_reponse' => 'integer',
    ];

    // Relations
    public function question()
    {
        return $this->belongsTo(Question::class, 'id_question', 'id_question');
    }

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'id_candidature', 'id_candidature');
    }
}
