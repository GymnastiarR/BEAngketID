<?php

use App\Helpers\Slug;
use App\Models\Form;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\Auth;
use App\Models\Age;

class FormStore{

    public static function store($request, $slug, $isPublish){

        // return $request;

        $age = Age::create([
            'from' => $request->age['from'],
            'to' => $request->age['to'],
        ]);

        $data = [
            'title' => $request->title,
            'user_id' => Auth::id(),
            'points' => $request->points,
            'description' => $request->description,
            'slug' => $slug,
            'age_id' => $age->id,
            'status' => $request->status,
            'education_id' => $request->education,
        ];

        if($isPublish){
            $data['publish_at'] = now();
        }

        // return $data;

        $form = Form::create($data);

        // return $form;

        foreach($request->questions as $question){

            $quest = self::storeQuestion($question, $form);

            if($question['type'] == 3){
                continue;
            }

            foreach($question['options'] as $option){
                Option::create([
                    'content' => $option['content'],
                    'question_id' => $quest->id
                ]);
            }
        }

        return $form;
    }

    private static function storeQuestion($question, $form){
        return Question::create([
            'content' => $question['content'],
            'tipe' => $question['type'],
            'form_id' => $form->id
        ]);
    }
}