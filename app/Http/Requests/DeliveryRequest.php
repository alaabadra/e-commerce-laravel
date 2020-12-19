<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'delivery_status'=>'required|in:1|0'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This  field is required',
            'delivery_status.in'=>'Status Delivery  must be 0 or 1',
        ];
    }
}
