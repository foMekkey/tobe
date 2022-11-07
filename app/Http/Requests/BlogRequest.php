<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        $rules['lang'] = 'required';
        $rules['image'] = 'required';
        $rules['title'] = 'required';
        $rules['date'] = 'required';
        $rules['content'] = 'required';
        $rules['created_by'] = 'required';

        return $rules;
    }
}
