<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'review_description'=>'required|string',
            'review_rank'=>'required|integer'
            
        ];
    }
    public function messages()
    {
        return [
            'required'=>'This is required',
            'review_description.string'=>'Review Description must be string',
            'review_rank.integer'=>'Review Rank must be integer'
        ];
    }
}
