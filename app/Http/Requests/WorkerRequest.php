<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerRequest extends FormRequest
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
        $rules1=[
            'behavior' =>"required|integer|min:1|max:5",
            'time'=>"required|integer|min:1|max:5",

        ];

        if ($this->path() === 'api/submit-weight') {
            return $rules1;
        }
else {
    // adding the validation rules of each worker attribute
    $rules2=[
    'first_name' => 'required|string|min:3|max:10',

    'last_name' => 'required|string|min:5|max:15',

    'email' => 'email:rfc,dns|required',

    'password' => 'required| min:6|regex:"^([a-zA-Z0-9@*#]{8,15})"|confirmed',

    'age' => 'numeric|min:17|max:65|required',

    'salary' => 'numeric|min:2500|max:50000|required',

    'vehicle_type' => 'required|string|min:3|max:15|',

    'role' => 'numeric|min:1|max:100|required',

    'government' => 'required|string|min:4|max:15',
    ];
    return $rules2;
}
    }
}
