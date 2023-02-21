<?php

namespace App\Http\Requests\Country;

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
            'name'        => ['required'],
            'code'        => ['required'],
            'phone_code'        => ['required'],
            'nationality'        => ['required'],
            'status'     => ['required'],
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
            'phone_code.required' => 'Country Phone code name is required.',
            'nationality.required' => 'Country nationality name is required.',
            'status.required'=>'Status is required.'
        ];
    }
}
