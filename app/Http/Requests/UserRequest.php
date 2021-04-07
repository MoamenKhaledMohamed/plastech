<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        // adding the validation rules of each user attribute
        return[
            'first_name' => 'required|string|min:3|max:10',

            'last_name' => 'required|string|min:5|max:15',

            'email' => 'email:rfc,dns|required|unique:users,email',

            'password' => 'required| min:6|regex:"^([a-zA-Z0-9@*#]{8,15})"|confirmed',

            'date_of_birth' => 'required|date|date_format:Y-m-d',

            'number_of_points' => '|numeric|digits_between:0,5|',

            'government' => 'required|string|min:4|max:15',
        ];
    }
}
