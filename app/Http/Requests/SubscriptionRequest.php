<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
        $rules['course_id'] = 'required';
        $rules['payment_method'] = 'required';
        $rules['amount'] = 'required';
        $rules['currency'] = 'sometimes|nullable';
        $rules['transfer_date'] = 'required';
        $rules['status'] = 'sometimes|nullable';
        $rules['bank_id'] = 'sometimes|nullable';
        $rules['user_bank_acc_name'] = 'sometimes|nullable';
        $rules['e_wallet_id'] = 'sometimes|nullable';
        $rules['user_e_wallet_number'] = 'sometimes|nullable';
        
        return $rules;
    }
}
