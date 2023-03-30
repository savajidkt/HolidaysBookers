<?php

namespace App\Http\Requests\Package;

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
            'package_name'        => ['required'],
            'package_code'     => ['required'],
            'package_validity'     => ['required'],
            'nationality'     => ['required'],
            // 'rate_per_adult'     => ['required'],
            // 'rate_per_child_cwb'     => ['required'],
            // 'rate_per_child_cnb'     => ['required'],
            // 'rate_per_infant'     => ['required'],
            // 'minimum_pax'     => ['required'],
            // 'maximum_pax'     => ['required'],
            'cancel_day'     => ['required'],
            'status'     => ['required'],
            'highlights'     => ['required'],
            'terms_and_conditions'     => ['required'],
            'hotel_name_id'     => ['required'],
            'room_type'     => ['required'],
            'meal_plan'     => ['required'],
            // 'travel_validity'     => ['required'],            
            'cutoff_price'     => ['required'],
            'duration'     => ['required'],
            // 'sold_out_dates'     => ['required'],            
            'sleepsmax'     => ['required'],
            'maxadults'     => ['required'],
            'maxchildwmaxadults'     => ['required'],
            'maxchildwoextrabed'     => ['required'],
            'mincwbage'     => ['required'],
            'mincwobage'     => ['required'],
            'currency_id'     => ['required'],
            'marketprice'     => ['required'],
            'rate_offered'     => ['required'],
            'singleadult'     => ['required'],
            'twinsharing'     => ['required'],
            'extraadult'     => ['required'],
            'cwb'     => ['required'],
            'cob'     => ['required'],
            'ccob'     => ['required'],
            'singleadulttax'     => ['required'],
            'twinsharingtax'     => ['required'],
            'extraadulttax'     => ['required'],
            'cwbtax'     => ['required'],
            'cobtax'     => ['required'],
            'ccobtax'     => ['required']
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
            'package_name.required' => "Package name is required",
            'package_code.required' => "Package code is required",
            'package_validity.required' => "Package validity is required",
            'nationality.required' => "Package nationality is required",
            // 'rate_per_adult.required' => "Package rate per adult is required",
            // 'rate_per_child_cwb.required' => "Package rate per child cwb is required",
            // 'rate_per_child_cnb.required' => "Package rate per child cnb is required",
            // 'rate_per_infant.required' => "Package rate per infant is required",
            // 'minimum_pax.required' => "Package minimum pax is required",
            // 'maximum_pax.required' => "Package maximum pax is required",
            'cancel_day.required' => "Package cancel day is required",
            'highlights.required' => "Package highlights is required",
            'terms_and_conditions.required' => "Package terms and conditions is required",
            'status.required' => "Package status is required",
            'hotel_name_id.required' => "Hotel is required",
            'room_type.required' => "Room type is required",
            'meal_plan.required' => "Meal plan is required",
            // 'travel_validity.required' => "Travel validity is required",
            'cutoff_price.required' => "Cut-off for booking is required",
            'duration.required' => "Min length of stay is required",
            // 'sold_out_dates.required' => "Sold out dates is required",
            'sleepsmax.required' => "Max allowed (Adults + Child) is required",
            'maxadults.required' => "Max adults allowed in the room is required",
            'maxchildwmaxadults.required' => "Max children when max adults is required",
            'maxchildwoextrabed.required' => "Max children without extra bed is required",
            'mincwbage.required' => "Min. child with bed age is required",
            'mincwobage.required' => "Min. child w/o bed age is required",
            'currency_id.required' => "Currency is required",
            'marketprice.required' => "Market price per night is required",
            'rate_offered.required' => "Rate offered is required",
            'singleadult.required' => "Single sharing is required",
            'twinsharing.required' => "Twin sharing is required",
            'extraadult.required' => "Extra adult is required",
            'cwb.required' => "Child with bed is required",
            'cob.required' => "Child without bed is required",
            'ccob.required' => "Infant/Complimentary child is required",
            'singleadulttax.required' => "Single sharing is required",
            'twinsharingtax.required' => "Twin sharing is required",
            'extraadulttax.required' => "Extra adult is required",
            'cwbtax.required' => "Child with bed is required",
            'cobtax.required' => "Child without bed is required",
            'ccobtax.required' => "Infant/Complimentary child is required",
        ];
    }
}
