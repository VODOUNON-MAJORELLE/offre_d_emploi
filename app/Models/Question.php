<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'id_question';

    protected $fillable = [
        'id_questionnaire',
        'enonce_question',
        'type_question',
        'points_question',
        'mots_cles',
    ];

    protected $casts = [
        'points_question' => 'integer',
    ];

    // Relations
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'id_questionnaire', 'id_questionnaire');
    }

    public function options()
    {
        return $this->hasMany(OptionReponse::class, 'id_question', 'id_question')->orderBy('ordre_option', 'asc');
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'id_question', 'id_question');
    }
}
