<?php

namespace App\Http\Requests\VehicleType;

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
            'vehicle_name'        => 'required',
            'no_of_seats'        => 'required|numeric',
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
            'vehicle_name.required' => __('vehicletype/message.vehicle_name_required'),
            'no_of_seats.required' => __('vehicletype/message.no_of_seats_required'),
            'no_of_seats.numeric' => __('vehicletype/message.no_of_seats_number_required'),
            'status.required' => __('vehicletype/message.status_required'),
        ];
    }
}
