<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TraineeCourseRequest extends FormRequest
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
        $rules['user_id'] = 'required';
        $rules['category_id'] = 'required';
        $rules['name'] = 'required';
        $rules['level'] = 'required';
        $rules['desc'] = 'required';
        $rules['price'] = 'required';
        $rules['duration'] = 'required';
        $rules['dateRange'] = 'required';

        return $rules;
    }
}