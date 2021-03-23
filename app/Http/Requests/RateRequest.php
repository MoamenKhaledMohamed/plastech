<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
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
        // adding the validation rules of rating Factors
             return [
                 'behavior' =>"required|integer|min:1|max:5",
                 'time'=>"required|integer|min:1|max:5",
             ];

    }
}
