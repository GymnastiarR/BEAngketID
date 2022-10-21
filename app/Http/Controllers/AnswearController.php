<?php

namespace App\Http\Controllers;

use App\Models\Answear;
use App\Http\Requests\StoreAnswearRequest;
use App\Http\Requests\UpdateAnswearRequest;
use App\Models\Activity;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Form;
use App\Models\User;

class AnswearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::with(['age'])->where('publish_at', '!=', \null)->where('user_id', '!=', Auth::id())->get();

        // $result = $forms->where('age.from', '<=', Auth::user()->age)->where('age.to', '>=', Auth::user()->age);
        // $result->merge($forms->where('age', \null));

        $result = $forms->filter(function($value, $key){
            return ((($value->age == \null) || ($value->age->from <= Auth::user()->age && $value->age->to >= Auth::user()->age)) 
                && ($value->status == Auth::user()->status || $value->status == \null ) 
                && ($value->education_id == Auth::user()->eduaction || $value->education_id == \null));
        });
        // $result->merge($forms)

        return $result->all();
        
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
     * @param  \App\Http\Requests\StoreAnswearRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnswearRequest $request)
    {
        // return $request;
        // $request->validate([
        //     "form_id" => "required",
        //     "options.*.question_id" => "required",
        //     "options.*.answear" => "required",
        // ]);

        // return Form::where('id', $request->form_id)->first('user_id');

        // if(Form::where('id', $request->form_id)->first('user_id')->user_id == Auth::id()){
        //     return \response()->json(["message" => "Pemiliki tidak diperbolehkan mengisi angket yang dimiliki"]);
        // }
        
        $activity = Activity::create([
            "user_id" => Auth::id(),
            "form_id" => $request->form_id
        ]);

        foreach($request->options as $option){
            // return $option;
            if((int)Question::where('id', $option['question_id'])->get('tipe')[0]->tipe == 3 || (int)Question::where('id', $option['question_id'])->get('tipe')[0]->tipe == 2){
                // return $option;
                Answear::create([
                    "content" => $option['data']['answer'],
                    "activity_id" => $activity->id,
                    "question_id" => $option['question_id']
                ]);
                continue;
            }

            foreach($option['data']['answer'] as $answer){
                Answear::create([
                    "activity_id" => $activity->id,
                    "option_id" => $answer,
                    "question_id" => $option['question_id']
                ]);
            }
            
        }

        $form =  Form::find($request->form_id);

        $user = User::find(Auth::id());
        $user->points = $user->points + $form->points;
        $user->save();

        $user = User::find($form->user_id);
        $user->points = $user->points - $form->points;

        if($user->point < 0){
            $forms = Form::where('user_id', $user->id);
            foreach($forms as $form){
                $form = Form::find($form->id);
                $form->points = "";
                $form->save();
            }
        }

        // if($user->points < 0){
            
        // }

        $user->save();

        return \response()->json(["pesan" => "Jawaban telah dikirim"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answear  $answear
     * @return \Illuminate\Http\Response
     */
    public function show(Answear $answear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answear  $answear
     * @return \Illuminate\Http\Response
     */
    public function edit(Answear $answear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnswearRequest  $request
     * @param  \App\Models\Answear  $answear
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnswearRequest $request, Answear $answear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answear  $answear
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answear $answear)
    {
        //
    }
}
