<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'banner_image'=>'required|mimes:jpg|jpeg|png'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This field is required',
            'banner_image.mimes'=>'The Image must be valid'
        ];
    }
}
