<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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

    public function rules()
    {
        return [
            'category_name'=>'required|string',
            'category_language'=>'required|string',
            'category_description'=>'required|string',
            'category_image'=>'required|mimes:jpg|jpeg|png',
            'category_status'=>'required|in:1|0'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This  field is required',
            'category_language.string'=>'Language Category must be string',
            'category_description.string'=>'Description Category must be string',
            'category_image.mimes'=>'The Image must be valid',
            'category_status.in'=>'Status Category  must be 0 or 1'
        ];
    }
}
