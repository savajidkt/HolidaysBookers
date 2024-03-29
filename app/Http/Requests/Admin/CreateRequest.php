<?php

namespace App\Http\Requests\Admin;

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
            'fullname'          => ['required'],
            'role'              => ['required'],
            'password'          => ['required', 'min:6'],
            'confirm_password'  => ['required'],
            'email'             => ['required', 'email', 'unique:admin,email'],
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
            'fullname.required' => 'Name is required.',
            'role.required' => 'Role is required.',
            'password.required' => 'Password is required.',
            'confirm_password.required' => 'Confirm Password is required.',
            'password.min' => 'Password minimum value should be 6'
        ];
    }
}
