<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class E_WalletRequest extends FormRequest
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
        $rules['number'] = 'required';
        $rules['company_name_ar'] = 'required';
        $rules['company_name_en'] = 'required';
        $rules['active'] = 'sometimes|nullable';
        return $rules;
    }
}
