<?php
namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
        return back()->with('success', 'Question supprimée !');
    }
}