<?php

namespace App\Http\Requests\OfflineRoom;

use Illuminate\Http\Request;
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
            'first_name'     => ['required'],           
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
            'first_name.required' => 'First name is required',           
            'status.required' => 'Status is required'
        ];
    }
}