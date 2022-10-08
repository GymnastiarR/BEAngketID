<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\User;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // return $slug;
        // return $request->slug;
        // Activity::where('form_id', Form::where('slug', $request->slug)->get('id'));
        // return Form::with([''])->where('slug', $slug)->get();
        
        // return Activity::with('user.form')

        // return Activity::all();

        $id =  Form::with('activities')->where('slug', $slug)->first()->activities->pluck('user_id');

        return User::with(['activities.form.questions.options','activities.form.questions.answears'])->whereIn('id', $id)->get();
        // return \response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
