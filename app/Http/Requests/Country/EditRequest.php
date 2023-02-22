<?php

namespace App\Http\Requests\Country;

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
            'name'        => 'required',
            'code'        => 'required',
            'phone_code'        => 'required|numeric|max:4|min:1',
            'nationality'        => 'required',
            'status'     => 'required',
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
            'name.required' => 'Country name is required.',
            'code.required' => 'Country code is required.',
            'phone_code.required' => 'Country phone code is required.',
            'phone_code.numeric' => 'Phone code it should be number only.',
            'phone_code.min' => 'Phone code minimum one digit.',
            'phone_code.max' => 'Phone code maximum four digit.',
            'nationality.required' => 'Country nationality is required.',
            'status.required' => 'Status is required.'
        ];
    }
}
