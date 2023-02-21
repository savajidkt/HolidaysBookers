<?php

namespace App\Http\Requests\HotelGroup;

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
            'group_name'        => ['required'],
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
            'group_name.required' => 'Hotel Group name is required.',
            'status.required'=>'Hotel Group status is required.'
        ];
    }
}
