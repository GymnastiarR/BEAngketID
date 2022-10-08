<?php

namespace App\Http\Controllers;

use App\Models\Answear;
use App\Http\Requests\StoreAnswearRequest;
use App\Http\Requests\UpdateAnswearRequest;
use App\Models\Activity;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

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

        // return "ok";

        $request->validate([
            "form_id" => "required",
            "options.*.question_id" => "required",
            "options.*.answear" => "required",
        ]);
        
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
