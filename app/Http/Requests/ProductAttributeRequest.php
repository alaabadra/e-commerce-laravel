<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeRequest extends FormRequest
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
            'product_attr_name'=>'required|string',
            'product_attr_image'=>'required|mimes:jpg|jpeg|png',
            'product_attr_price'=>'required|integer',
            'product_attr_quantity'=>'required|integer',
            'product_attr_status'=>'required|in:1|0'
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This  field is required',
            'product_attr_name.string'=>'Product Name must be string',
            'product_attr_image.mimes'=>'The Image must be valid',
            'product_attr_price.integer'=>'Product Price must be integer',
            'product_attr_quantity.integer'=>'Product Quantity must be integer',
            'product_attr_status.in'=>'product Status   must be 0 or 1',
        ];
    }
}
