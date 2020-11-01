<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegRequest extends FormRequest
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
            'name'=>'required|name',
            'email'=>'required|email',
            'password'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'name is required',
            'email.required'=>'email is required',
            'email.email'=>'email must be valid',
            'password.required'=>'password is required',
        ];
    }
}
