<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use Validator;
use App\Models\Test;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{   
    public function create(Test $test)
    {
        return view('question.create', compact('test'));
    }

    public function store(Request $request, Test $test)
    {
        $question = new Question;

        $validator = Validator::make($request->all(), [
            'questions.*.text' => 'required',
            'questions.*.correct' => 'required|array|min:1',
            'questions.*.image' => 'image',
            'questions.*.answer.*' => 'required',
        ]);

        if(!$validator->passes()) {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else { 
             $this->save($request, $question, $test);
         } 

        if ($question) {
            $request->session()->flash('success', 'Вопрос добавлен');
            return response()->json(['status'=>1, 'route' => '/test/details/' . $question->test_id]);
        } 
    }

    public function edit(Question $question)
    {
        return view('question.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
         $test = Test::find($question->test_id);

         $validator = Validator::make($request->all(), [
            'questions.*.text' => 'required',
            'questions.*.correct' => 'required|array|min:1',
            'questions.*.image' => 'image',
            'questions.*.answer.*' => 'required',
        ]);

        if(!$validator->passes()) {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else { 
             $this->save($request, $question, $test);
         }          
        

        if ($question) {
            $request->session()->flash('success', 'Изменение сохранены');
            return response()->json(['status'=>1, 'route' => '/test/details/' . $question->test_id]);
        }
 
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return back()->with('success', 'Вопрос удален успешно');
    }

    private function save(Request $request, Question $question, Test $test)
    {
        
            $input = $request->all();
            $requestQuestion = $input['questions'][0];            
            $question->text = $requestQuestion['text'];
            $question->test_id = $test->id;

           if (isset($requestQuestion['image'])) {

                if($question->img_path) {
                    Storage::delete('/public/' . $question->img_path);
                }              
                
                $question->img_path = $requestQuestion['image']->store('img', 'public');
            }

            $question->save();


            for ($i=0; $i < count($requestQuestion['answer']); $i++) { 
                if(isset($question->answers[$i])) {
                    $answer = $question->answers[$i];                    
                } else {
                    $answer = new Answer;
                }

                $answer->text = $requestQuestion['answer'][$i];
                $answer->question_id = $question->id;
                $answer->test_id = $question->test_id;

                if(isset($requestQuestion['correct'][$i])) {
                    $answer->correct_answer = true;
                } else {
                    $answer->correct_answer = false;
                }

                $answer->save();
            }
         
    }

    

    
}
