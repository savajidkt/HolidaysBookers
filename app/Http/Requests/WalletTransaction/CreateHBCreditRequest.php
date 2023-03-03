<?php

namespace App\Http\Requests\WalletTransaction;

use Illuminate\Foundation\Http\FormRequest;

class CreateHBCreditRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
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
        $rules = [
            'HBCredit_user_id'        => 'required',
            'amount'        => 'required|numeric',
            'type'     => 'required',
            'comment'     => 'required',
        ];

        return $rules;
    }    
}
