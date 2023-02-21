<?php

namespace App\Http\Requests\VehicleType;

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
            'vehicle_name'        => ['required'],
            'no_of_seats'        => ['required'],
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
            'vehicle_name.required' => 'Vehicle name is required.',
            'no_of_seats.required' => 'No of sheet is required.',
            'status.required'=>'Status is required.'
        ];
    }
}
