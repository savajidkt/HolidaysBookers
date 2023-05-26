<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'password'          => ['required', 'min:6', 'same:confirm-password'],
            'confirm-password'  => ['required', 'min:6'],
            'company'           => ['required'],
            'project'           => ['required'],
            'email'             => ['required', 'email', 'unique:users,email'],
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
            'password.min' => 'Password minimum value should be 8.',
            'password.same' => 'Password does not match with confirm password.',
            'confirm-password.min' => 'Password minimum value should be 8.'
        ];
    }
}
