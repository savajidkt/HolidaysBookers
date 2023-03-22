<?php

namespace App\Http\Requests\OfflineHotel;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        return [
            'hotel_name'        => ['required'],
             'hotel_country'        => ['required'],
             'hotel_state'        => ['required'],
             'hotel_city'        => ['required'],
            'category'         => ['required'],
            'hotel_group_id'         => ['required'],
            'phone_number'         => ['required'],
            'hotel_address'         => ['required'],
            'hotel_pincode'         => ['required'],
            'hotel_email'         => ['required'],
            'hotel_amenities'         => ['required'],
            'property_type_id'         => ['required'],
            'hotel_review'         => ['required'],
            'hotel_latitude'         => ['required'],
            'hotel_longitude'         => ['required'],
            'cancel_days'         => ['required'],
            'front_office_first_name'         => ['required'],
            'front_office_designation'         => ['required'],
            'front_office_contact_number'         => ['required'],
            'front_office_email'         => ['required'],
            'sales_first_name'         => ['required'],
            'sales_designation'         => ['required'],
            'sales_contact_number'         => ['required'],
            'sales_email'         => ['required'],
            'reservation_first_name'         => ['required'],
            'reservation_designation'         => ['required'],
            'reservation_contact_number'         => ['required'],
            'reservation_email'         => ['required'],
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
            'hotel_name.required' => 'Hotel is required.',
            'hotel_country.required' => 'Country is required.',
            'hotel_state.required' => 'State is required.',
            'hotel_city.required' => 'City is required.',
            'category.required' => 'Category is required.',
            'hotel_group_id.required' => 'Group is required.',
            'phone_number.required' => 'Phone number is required.',
            'hotel_address.required' => 'Address is required.',
            'hotel_pincode.required' => 'Pincode is required.',
            'hotel_email.required' => 'Email is required.',
            'hotel_amenities.required' => 'Amenity is required.',
            'property_type_id.required' => 'Property is required.',
            'hotel_review.required' => 'Review is required.',
            'hotel_latitude.required' => 'Latitude is required.',
            'hotel_longitude.required' => 'Longitude is required.',
            'cancel_days.required' => 'Cancel day is required.',
            'front_office_first_name.required' => 'Front office name is required.',
            'front_office_designation.required' => 'Front office designation is required.',
            'front_office_contact_number.required' => 'Front office contact number is required.',
            'front_office_email.required' => 'Front office email is required.',
            'sales_first_name.required' => 'Sales name is required.',
            'sales_designation.required' => 'Sales designation is required.',
            'sales_contact_number.required' => 'Sales contact number is required.',
            'sales_email.required' => 'Sales email is required.',
            'reservation_first_name.required' => 'Reservation name is required.',
            'reservation_designation.required' => 'Reservation designation is required.',
            'reservation_contact_number.required' => 'Reservation contact number is required.',
            'reservation_email.required' => 'Reservation email is required.',

        ];
    }
}
