<?php
namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\OptionReponse;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function store(Request $request, $id_offre)
    {
        $request->validate([
            'enonce_question' => 'required|string',
            'type_question'   => 'required|string',
            'points_question' => 'required|integer|min:1',
        ]);

        // Créer questionnaire si n'existe pas
        $questionnaire = Questionnaire::firstOrCreate(
            ['id_offre' => $id_offre],
            ['titre_questionnaire' => 'Questionnaire de candidature']
        );

        // Créer la question
        $question = Question::create([
            'id_questionnaire'  => $questionnaire->id_questionnaire,
            'enonce_question'   => $request->enonce_question,
            'type_question'     => $request->type_question,
            'points_question'   => $request->points_question,
        ]);

        // Créer les options si QCM
        if ($request->type_question === 'qcm' && $request->options) {
            foreach ($request->options as $i => $opt) {
                if (trim($opt)) {
                    OptionReponse::create([
                        'id_question'       => $question->id_question,
                        'contenu_option'    => $opt,
                        'est_bonne_reponse' => in_array($i, $request->bonne_reponse ?? []),
                        'ordre_option'      => $i + 1,
                    ]);
                }
            }
        }

        return back()->with('success', 'Question ajoutée !');
    }
}