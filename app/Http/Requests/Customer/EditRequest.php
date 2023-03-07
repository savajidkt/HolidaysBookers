<?php

namespace App\Http\Requests\Customer;

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
            'last_name'     => ['required'],
            'dob'     => ['required'],
            'country'     => ['required'],
            'state'     => ['required'],
            'city'     => ['required'],
            'zipcode'     => ['required'],
            'mobile_number'     => ['required'],
            'email_address'     => ['required'],            
            'status'     => ['required'],
        ];

        // if (strlen($request->password)  > 0) {
        //     $rules['password'] = ['required', 'min:6', 'same:confirm_password'];
        //     $rules['confirm_password'] = ['required', 'min:6'];
        // }

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
