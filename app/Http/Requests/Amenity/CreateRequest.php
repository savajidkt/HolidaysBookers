<?php

namespace App\Http\Requests\Amenity;

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
            'amenity_name'        => ['required'],
            'type'        => ['required'],
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
            'amenity_name.required' => 'Amenity name is required.',
            'type.required' => 'Amenity type is required.',
            'status.required' => 'Status is required.'
        ];
    }
}