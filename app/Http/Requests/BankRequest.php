<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
        $rules['bank_name_ar'] = 'required';
        $rules['bank_name_en'] = 'required';
        $rules['acc_name_ar'] = 'required';
        $rules['acc_name_en'] = 'required';
        $rules['acc_num'] = 'required';
        $rules['iban'] = 'required';
        $rules['active'] = 'required';

        return $rules;
    }
}
