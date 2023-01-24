<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Validator;
use Auth;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    
    public function show(Test $test)
    {  
       return view('test.show', compact('test'));
    }

    public function showDetails(Test $test)
    {
       return view('test.details', compact('test'));
    }

    public function showUserTest()
    {
        $tests = Test::where('user_id', Auth::user()->id)->paginate(20);

        return view('test.index', compact('tests'));
    }

    public function store(Request $request)
    {   
        $rules = [
            'title' => 'required',
            'testImage' => 'image|required',
            'description' => 'required',
            'questions.*.text' => 'required',
            'questions.*.image' => 'image',
            'questions.*.correct' => 'required|array|min:1',
            'questions.*.answer.*' => 'required',
        ];       


        $validator = Validator::make($request->all(), $rules);

        if(!$validator->passes()) {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else {

            //create test
         
            $test = new Test;
            $test->title =  $request->input('title');
            $test->description = $request->input('description');           
            $test->user_id = $request->input('user_id');

            if ($request->file('testImage')) {
                 $test->img_path = $request->file('testImage')->store('img', 'public');
            }

            if ($request->has('private')) {
                $test->private = true;
            }

            $test->save();
            $input = $request->all();

            //create questions
            foreach ($input['questions'] as $requestQuestion) {
                $question = new Question;
                $question->text = $requestQuestion['text'];
                $question->test_id = $test->id;

               if (isset($requestQuestion['image'])) {
                    $question->img_path = $requestQuestion['image']->store('img', 'public');

                }

                $question->save();

                for ($i=0; $i < count($requestQuestion['answer']); $i++) { 
                    $answer = new Answer;
                    $answer->text = $requestQuestion['answer'][$i];
                    $answer->question_id = $question->id;
                    $answer->test_id = $test->id;

                    if(isset($requestQuestion['correct'][$i])) {
                        $answer->correct_answer = true;
                    }

                    $answer->save();
                }
            }


            if ($test) {
                $request->session()->flash('success', 'Тест создан');
                return response()->json(['status'=>1, 'route' => '/']);
            }

        }
    }

    public function edit(Test $test)
    {
        return view('test.edit', compact('test'));
    }

    public function update(Request $request, Test $test)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'testImage' => 'image',
            'description' => 'required',
        ]);

         if(!$validator->passes()) {
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else { 

            $test->title =  $request->input('title');
            $test->description = $request->input('description');           
            $test->user_id = $request->input('user_id');

            if ($request->file('testImage')) {
                if($test->img_path) {
                    Storage::delete('/public/' . $test->img_path);
                }

                $test->img_path = $request->file('testImage')->store('img', 'public');
            }

            if ($request->has('private')) {
                $test->private = true;
            }

            $test->save();
            $request->session()->flash('success', 'Изменение сохранены');

            return response()->json(['status'=>1, 'route' => '/test/details/' . $test->id]);
        }


    }

    public function destroy(Test $test)
    {   
        $questions = Question::where('test_id', $test->id)->get();
        $answers = Answer::where('test_id', $test->id)->get();

        foreach ($questions as $question) {
            $question->delete();
        }

        foreach ($answers as $answer) {
            $answer->delete();
        }

        $test->delete();

        return redirect()->route('home')->with('success', 'Тест удален успешно');
    }

    
}
