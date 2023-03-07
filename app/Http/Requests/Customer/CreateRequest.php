<?php

namespace App\Http\Requests\Customer;

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
           
            'first_name'     => ['required'],
            'last_name'     => ['required'],
            'dob'     => ['required'],
            'country'     => ['required'],
            'state'     => ['required'],
            'city'     => ['required'],
            'zipcode'     => ['required'],
            'mobile_number'     => ['required'],
            'email_address'     => ['required', 'email', 'unique:users,email'],
            'password'          => ['required', 'min:6', 'same:confirm_password'],
            'confirm_password'  => ['required', 'min:6'],
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
            'last_name.required' => 'Last name is required',
            'dob.required' => 'Date of birth is required',
            'country.required' => 'Country is required',
            'state.required' => 'State is required',
            'city.required' => 'City is required',
            'zipcode.required' => 'Zipcode is required',
            'mobile_number.required' => 'Mobile number is required',
            'email_address.required' => 'Email address is required',
            'password.min' => 'Password minimum value should be 6.',
            'password.same' => 'Password does not match with confirm password.',
            'confirm_password.min' => 'Password minimum value should be 6.',
            'status.required' => 'Status is required'
        ];
    }
}
