<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'fullname'        => ['required'],
            'role'              => ['required'],
            'password'          => ['nullable', 'min:6'],
            'email'             => ['required', 'email', 'unique:admin,email,'.$this->admin->id],
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
            'password.min' => 'Password minimum value should be 6.',
        ];
    }
}
