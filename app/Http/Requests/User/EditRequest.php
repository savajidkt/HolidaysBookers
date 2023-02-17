<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
        $rules = [
            'first_name'        => ['required'],
            'last_name'         => ['required'],
            'password'          => ['nullable', 'min:8', 'same:confirm-password'],
            'confirm-password'  => ['nullable', 'min:8'],
            'email'             => ['required', 'email', 'unique:users,email,'.$this->user->id],
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
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'address.required' => 'Address is required.',
            'password.min' => 'Password minimum value should be 8.',
            'password.same' => 'Password does not match with confirm password.',
            'confirm-password.min' => 'Password minimum value should be 8.'
        ];
    }
}
