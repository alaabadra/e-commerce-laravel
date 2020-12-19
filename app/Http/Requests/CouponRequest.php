<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'coupon_code'=>'required',
            'coupon_code_amount_type'=>'required|in:Fixed|Precentage',
            'coupon_code_amount'=>'required|integer',
            'coupon_code_expiry_date'=>'required|date',
            'coupon_code_status'=>'required|in:1|0'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This  field is required',
            'coupon_code_amount_type.in'=>'Type Amount coupon code must be Fixed or Precentage',
            'coupon_code_amount.integer'=>'Amount coupon code must be integer',
            'coupon_code_expiry_date.date'=>'Coupon Code Expiry Date  must be valid date',
            'coupon_code_status.in'=>'Status coupon  must be 0 or 1',
        ];
    }
}
