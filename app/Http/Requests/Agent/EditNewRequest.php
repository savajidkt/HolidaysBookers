<?php

namespace App\Http\Requests\Agent;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class EditNewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
    public function rules(Request $request)
    {
        $rules = [
            'agent_company_name'        => ['required'],
            'agent_company_type'        => ['required'],
            'nature_of_business'        => ['required'],
            'agent_first_name'        => ['required'],
            'agent_last_name'         => ['required'],
            'agent_designation'         => ['required'],
            'agent_dob'         => ['required'],
            'agent_office_address'         => ['required'],
            'agent_country'         => ['required'],
            'agent_state'         => ['required'],
            'agent_city'         => ['required'],
            'agent_pincode'         => ['required'],
            'agent_mobile_number'         => ['required'],
            'agent_email'         => ['required'],
            'mgmt_first_name'         => ['required'],
            'mgmt_last_name'         => ['required'],
            'mgmt_contact_number'         => ['required'],
            'mgmt_email'         => ['required'],
            'account_first_name'         => ['required'],
            'account_last_name'         => ['required'],
            'account_contact_number'         => ['required'],
            'account_email'         => ['required'],
            'reserve_first_name'         => ['required'],
            'reserve_last_name'         => ['required'],
            'reserve_contact_number'         => ['required'],
            'reserve_email'         => ['required'],
            // 'agent_password'          => ['required', 'min:6', 'same:agent_confirm_password'],
            // 'agent_confirm_password'  => ['required', 'min:6'],
        ];
        if ($request->agent_iata == "yes") {
            $rules['agent_iata_number'] = ['required'];
        }

        // if (strlen($request->agent_username) > 0) {
        //     $rules['agent_username'] = ['required', 'email', 'unique:users,email,' . $request->id];
        // } else {
        //     $rules['agent_username'] = ['required'];
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
            'agent_company_name.required' => 'Company name is required.',
            'agent_company_type.required' => 'Company type is required.',
            'nature_of_business.required' => 'Nature of business is required.',
            'agent_first_name.required' => 'First name is required.',
            'agent_last_name.required' => 'Last name is required.',
            'agent_designation.required' => 'Designation is required.',
            'agent_dob.required' => 'Date of birth is required.',
            'agent_office_address.required' => 'Address is required.',
            'agent_country.required' => 'Country is required.',
            'agent_state.required' => 'State is required.',
            'agent_city.required' => 'City is required.',
            'agent_pincode.required' => 'Pincode is required.',
            'agent_mobile_number.required' => 'Mobile number is required.',
            'agent_email.required' => 'Email is required.',
            'agent_iata_number.required' => 'IATA number is required.',
            'mgmt_first_name.required' => 'First name is required.',
            'mgmt_last_name.required' => 'Last name is required.',
            'mgmt_contact_number.required' => 'Contact number is required.',
            'mgmt_email.required' => 'Email is required.',
            'account_first_name.required' => 'First name is required.',
            'account_last_name.required' => 'Last name is required.',
            'account_contact_number.required' => 'Contact number is required.',
            'account_email.required' => 'Email is required.',
            'reserve_first_name.required' => 'First name is required.',
            'reserve_last_name.required' => 'Last name is required.',
            'reserve_contact_number.required' => 'Contact number is required.',
            'reserve_email.required' => 'Email is required.',
            'agent_username.required' => 'Email is required.',
            'agent_password.min' => 'Password minimum value should be 6.',
            'agent_password.same' => 'Password does not match with confirm password.',
            'agent_confirm_password.min' => 'Password minimum value should be 6.',
        ];
    }
}
