<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'cart_color'=>'required|string',
            'cart_status'=>'required|in:1|0',
            'cart_size'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This is required',
            'cart_color.string'=>'Color Cart must be string',
            'cart_status.in'=>'Status Cart  must be 0 or 1'
        ];
    }
}
