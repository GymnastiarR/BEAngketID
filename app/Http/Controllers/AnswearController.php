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
        
        // $request->validate([
        //     "form_id" => "required",
        //     "options.*.question_id" => "required",
        //     "options.*.answear" => "required",
        // ]);

        if(Form::where('id', $request->form_id)->get('user_id') == Auth::id()){
            return \response()->json(["message" => "Pemiliki tidak diperbolehkan mengisi angket yang dimiliki"]);
        }
        
        $activity = Activity::create([
            "user_id" => Auth::id(),
            "form_id" => $request->form_id
        ]);
    

        foreach($request->options as $option){
            if((int)Question::where('id', $option['question_id'])->get('tipe')[0]->tipe == 3){
                Answear::create([
                    "content" => $option['answear'],
                    "activity_id" => $activity->id,
                    "question_id" => $option['question_id']
                ]);

                continue;
            }

            foreach($option['answear'] as $answear){
                Answear::create([
                    "activity_id" => $activity->id,
                    "option_id" => $answear,
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
