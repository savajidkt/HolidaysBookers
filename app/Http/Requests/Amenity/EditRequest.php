<?php

namespace App\Http\Requests\Amenity;

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
            'amenity_name.required' => __('amenity/message.amenity_name_required'),
            'type.required' => __('amenity/message.amenity_type_required'),
            'status.required' => __('amenity/message.status_required')
        ];
    }
}
