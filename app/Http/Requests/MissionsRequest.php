<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MissionsRequest extends FormRequest
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
        $rules['name'] = 'required';
        $rules['desc'] = 'required';
        $rules['mission_to'] = 'required|in:1,2';
        $rules['student_id'] = 'required_if:mission_to,1';
        $rules['group_id'] = 'required_if:mission_to,2';
        $rules['expire_date'] = 'required';

        return $rules;
    }
}
