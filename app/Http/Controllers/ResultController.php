<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Result;
use App\Models\Answer;
use App\Models\Question;
use Validator;

class ResultController extends Controller
{
   

    public function check(Request $request,Test $test)
    {  
        $rules = [
            'questions.*.correct' => 'required|array|min:1',
            'questions.*.correct.*' => 'required'
        ];

        

        $validator = Validator::make($request->all(), $rules);

       
       if(!$validator->passes()) {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else { 
            $count = 0;
            $input = [];

            foreach ($request->input('questions') as $key => $val) {
              $question = Question::find($key);
              $clientAnswers = $val['correct'];
              $input[$key] = $clientAnswers;
              $correctAnswers = Answer::where('question_id', $key)->where('correct_answer', 1)->get();
              $correctAnswersId = Answer::where('question_id', $key)->where('correct_answer', 1)->pluck('id')->toArray();

              if (array_values($clientAnswers) == array_values($correctAnswersId)) {
               $count++;
              }

             if(isset($clientAnswers[$correctAnswers[0]->id]) && $correctAnswers[0]->text == $clientAnswers[$correctAnswers[0]->id]) {
                $count++;
              }

            }

            $request->session()->put('input', $input);
            $request->session()->put('count', $count);

            return response()->json([
              'status'=>1,
              'route' => '/result/' . $test->id,
              
            ]);
            
         }
      

      
   }

   public function show(Request $request, Test $test)
   { 
     $input = $request->session()->get('input');
     $count = $request->session()->get('count');
     return view('result.show', compact('test', 'count', 'input'));
   }
}
