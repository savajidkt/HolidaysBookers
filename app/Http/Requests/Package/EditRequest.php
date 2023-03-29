<?php

namespace App\Http\Requests\Package;

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
        return [
            'package_name'        => ['required'],
            'package_code'     => ['required'],
            'package_validity'     => ['required'],
            'nationality'     => ['required'],
            'rate_per_adult'     => ['required'],
            'rate_per_child_cwb'     => ['required'],
            'rate_per_child_cnb'     => ['required'],
            'rate_per_infant'     => ['required'],
            'minimum_pax'     => ['required'],
            'maximum_pax'     => ['required'],
            'cancel_day'     => ['required'],
            'status'     => ['required'],
            'highlights'     => ['required'],
            'terms_and_conditions'     => ['required'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'package_name.required' => "Package name is required",
            'package_code.required' => "Package code is required",
            'package_validity.required' => "Package validity is required",
            'nationality.required' => "Package nationality is required",
            'rate_per_adult.required' => "Package rate per adult is required",
            'rate_per_child_cwb.required' => "Package rate per child cwb is required",
            'rate_per_child_cnb.required' => "Package rate per child cnb is required",
            'rate_per_infant.required' => "Package rate per infant is required",
            'minimum_pax.required' => "Package minimum pax is required",
            'maximum_pax.required' => "Package maximum pax is required",
            'cancel_day.required' => "Package cancel day is required",
            'highlights.required' => "Package highlights is required",
            'terms_and_conditions.required' => "Package terms and conditions is required",
            'status.required' => "Package status is required",
        ];
    }
}
