<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'language_abbr'=>'required|max:2|string',
            'language_name'=>'required|max:3|string',
            'language_direction'=>'required|in:rtl,ltr',
            'language_status'=>'required|in:0,1'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This field is required',
            'language_abbr.string'=>'abbrevation the langauge must be string',
            'language_name.string'=>'Name the langauge must be string',
            'language_name.max'=>'Name the langauge must be more than 3',
            'language_abbr.max'=>'Name the langauge must be more than 2',
            'in'=>'The value that enterned not correct'
        ];
    }
}
