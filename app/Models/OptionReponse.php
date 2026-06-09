<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionReponse extends Model
{
    protected $primaryKey = 'id_option';

    protected $fillable = [
        'id_question', 'contenu_option', 'est_bonne_reponse', 'ordre_option'
    ];

    public function question() {
        return $this->belongsTo(Question::class, 'id_question', 'id_question');
    }
}