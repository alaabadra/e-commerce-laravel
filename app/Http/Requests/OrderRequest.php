<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'order_payment_method'=>'required|string',
            'order_number'=>'required|integer',
            'order_price'=>'required',
            'order_shipping_tax'=>'required|integer',
            'order_shipping_cost'=>'required',
            'order_status'=>'required|in:1|0'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This  field is required',
            'order_payment_method.string'=>'Order Payment Method must be string',
            'order_number.integer'=>'Order Number must be integer',
            'order_shipping_tax.integer'=>'Order Sipping Tax must be integer',
            'coupon_code_status.in'=>'Status coupon  must be 0 or 1',
        ];
    }
}
