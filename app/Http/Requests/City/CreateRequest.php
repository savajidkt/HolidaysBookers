<?php

namespace App\Http\Requests\City;

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
            'country_id'        => ['required'],
            'state_id'        => ['required'],
            'name'        => ['required'],            
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
            'country_id.required' => __('city/message.country_name_required'),
            'state_id.required' =>  __('city/message.state_name_required'),
            'name.required' =>  __('city/message.city_name_required'),            
            'status.required' =>  __('city/message.status_required')
        ];
    }
}
