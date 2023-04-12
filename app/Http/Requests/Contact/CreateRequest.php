<?php

namespace App\Http\Requests\Contact;

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
            'name'        => 'required',
            'email'        => 'required|email',
            'phone'        => 'required|numeric|digits:10',
            'message'     => 'required',
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
            'name.required' => 'Full Name is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Contact number is required',
            'phone.numeric' => 'Please specify a valid phone number',
            'phone.min' => 'Please enter minimum 10 number',
            'phone.max' => 'Please enter maximum 10 number',
            'message.required' => 'Message is required',
        ];
    }
}
