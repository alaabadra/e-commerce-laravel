<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PincodeRequest extends FormRequest
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
            'pincode'=>'required',
            'pincode_status'=>'required|in:1|0'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This  field is required',
            'pincode_status.in'=>'Status coupon  must be 0 or 1',
        ];
    }

}
