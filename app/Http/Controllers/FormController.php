<?php

namespace App\Http\Controllers;

use App\Helpers\Slug;
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
use FormStore;
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

        $slug = Slug::create();
        
        return \response()->json(FormStore::store($request, $slug, 1));

    }

    public function storeDraft(StoreFormRequest $request){
        $slug = Slug::create();
        
        return \response()->json(FormStore::store($request, $slug, \null));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        // return $form;

        $form = Form::with('questions.options')->where('slug', $form->slug)->get();

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
        if($form->user_id != Auth::id()){
            return \response()->json(['status' => 'error', 'message' => 'Tidak bisa menghapus form']);
        }

        Form::destroy($form->id);
        return \response()->json(['message' => 'Form Deleted'], 200);
    }
}
