<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|max:3|string',
            'photo'=>'required|mimes:jpg|jpeg|png',
            'email'=>'required|email|unique'.$this->id,
            'password'=>'required|string|max:6',
            'image'=>'required|mimes:jpg|jpeg|png'

        ];
    }
    public function messages()
    {
        return [
            'required'=>'This is required',
            'image.mimes'=>'The Image must be valid',
            'name.max'=>'Name must be more than 3',
            'name.string'=>'Name must be charecters',
            'mimes.photo'=>'Image must be valid',
            'email.email'=>'Email must be valid',
            'email.unique'=>'Email must be unique',
            'password.max'=>'Password must be more than 3',
            'password.string'=>'Password must be charecters',
        ];
    }
}
