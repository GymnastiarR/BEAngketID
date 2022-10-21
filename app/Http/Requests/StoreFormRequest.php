<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'points' => 'numeric|nullable|between:10,20',
            'age.from' => 'numeric|nullable', //For Restriction
            'age.to' => 'numeric|nullable', //For Restriction
            'status' => 'in:Menikah,Lajang|nullable',
            'education_id' => 'between:1,3',
            'questions.*.content' => 'required',
            'questions.*.type' => 'required|numeric|between:1,3',
            'questions.*.options.*.content' => 'required'
        ];
    }
}
