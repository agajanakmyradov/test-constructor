<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Answer;
use App\Models\Question;

class AnswerController extends Controller
{   
    public function create(Question $question)
    {
        return view('answer.create', compact('question'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required',
        ]);

        $question = Question::find($request->input('question_id'));

        $answer = new Answer;
        $answer->text = $request->input('text');
        $answer->question_id = $question->id;
        $answer->test_id = $question->test_id;

        if ($request->input('correct_answer')) {
            $answer->correct_answer = true;
        }

        $answer->save();
        return redirect()->route('question.edit', ['question' => $question->id])->with('success', 'Ответ добавлен успешно');
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();

        return back()->with('success', ' Ответ удален');
    }
}
