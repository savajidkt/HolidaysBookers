<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'firstname'        => 'required',
            'lastname'        => 'required|numeric',
            'email'     => 'required', 'email', 'unique:users,email',
            'phone'     => 'required',
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.required' =>  'First name is required.',
            'lastname.required' => 'Last name is required.',
            'email.numeric' => 'Email is required.',
            'phone.required' => 'Phone number is required.',
        ];
    }
}
