<?php

use App\Helpers\Slug;
use App\Models\Form;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;

class FormStore{

    public static function store($request, $slug, $isPublish){

        $data = [
            'title' => $request->title,
            'user_id' => Auth::id(),
            'points' => $request->points,
            'description' => $request->description,
            'slug' => $slug
        ];

        if($isPublish){
            $data['isPublish'] = '1';
        }

        $form = Form::create($data);

        foreach($request->questions as $question){

            $quest = self::storeQuestion($question, $form);

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

        return $form;
    }

    private static function storeQuestion($question, $form){
        return Question::create([
            'content' => $question['content'],
            'tipe' => $question['tipe'],
            'form_id' => $form->id
        ]);
    }
}