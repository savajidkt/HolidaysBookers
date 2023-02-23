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
            'name'        => 'required',
            'code'        => 'required',
            'phone_code'        => 'required|numeric',
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
            'name.required' => __('country/message.country_name_required'),
            'code.required' => __('country/message.country_code_required'),
            'phone_code.required' => __('country/message.country_phone_code_required'),
            'phone_code.numeric' => __('country/message.country_phone_number_only_required'),
            'phone_code.min' => __('country/message.country_phone_number_min_required'),
            'phone_code.max' => __('country/message.country_phone_number_max_required'),
            'nationality.required' => __('country/message.country_nationality_required'),
            'status.required' => __('country/message.status_required'),
        ];
    }
}
