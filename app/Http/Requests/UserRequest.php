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
    public function rules()
    {
        $rules['user_name'] = 'required';
        $rules['l_name'] = 'required';
        $rules['f_name'] = 'required';
        $rules['email'] = 'required|unique:users';
        $rules['password'] = 'required';
        $rules['type'] = 'required';

        return $rules;
    }

}
