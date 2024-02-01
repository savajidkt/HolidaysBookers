<?php

namespace App\Http\Requests\HotelFacilities;

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
        return [
            'facility_id'        => ['required'],
            'name'        => ['required'],            
            'status'     => ['required'],
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
            'facility_id.required' => 'Hotel facilities name is required.',
            'name.required' => 'Hotel facility name is required.',            
            'status.required' => 'Status is required.'
        ];
    }
}
