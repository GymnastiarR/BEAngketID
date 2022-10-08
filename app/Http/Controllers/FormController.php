<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\QuestionController;
use Dotenv\Validator as DotenvValidator;
use Exception;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $forms = DB::table('forms')->where('user_id', Auth::id())->paginate(8);

        return \response()->json($forms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'point' => 'nullable|beetwen:10,20',
            'questions.*.content' => 'required',
            'questions.*.tipe' => 'required|numeric'
            // 'questions.*.options.*' => 'required'
        ]);

        $arr = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];

        $slug = [];
        for($i = 0 ; $i < 30 ; $i++){
            $slug[] = $arr[rand(1, 50)];
        }
        $slug = join("", $slug);

        $form = Form::create([
            'title' => $request->title,
            'user_id' => Auth::id(),
            'points' => $request->points,
            'description' => $request->description,
            'slug' => $slug
        ]);

        foreach($request->questions as $question){

            $quest = Question::create([
                'content' => $question['content'],
                'tipe' => $question['tipe'],
                'form_id' => $form->id
            ]);

            if(!$question['options']){
                continue;
            }
            foreach($question['options'] as $option){
                Option::create([
                    'content' => $option,
                    'question_id' => $quest->id
                ]);
            }
        }
        
        return \response()->json($form);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {

        $form = Form::with('questions.options')->find($form);

        return \response()->json($form);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormRequest  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        Form::destroy($form->id);

        return \response()->json(['message' => 'Form Deleted'], 200);
    }
}
