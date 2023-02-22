<?php

namespace App\Http\Requests\State;

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
            'country_id'        => ['required'],
            'name'        => ['required'],
            'code'        => ['required'],
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
            'country_id.required' => 'Country name is required.',
            'name.required' => 'State name is required.',
            'code.required' => 'State code name is required.',
            'status.required' => 'Status is required.'
        ];
    }
}
