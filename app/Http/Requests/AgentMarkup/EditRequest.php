<?php

namespace App\Http\Requests\AgentMarkup;

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
            'code'        => ['required'],
            'rezlive'        => ['required'],
            'offline_hotel'        => ['required'],
            'sightseeing'        => ['required'],
            'transfer'        => ['required'],
            'package'        => ['required'],
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
            'code.required' => __('agent-markup/message.product_markup_code_required'),
            'rezlive.required' => __('agent-markup/message.product_markup_rezlive_markup_required'),
            'offline_hotel.required' => __('agent-markup/message.product_markup_offline_hotel_markup_required'),
            'sightseeing.required' => __('agent-markup/message.product_markup_sightseeing_required'),
            'transfer.required' => __('agent-markup/message.product_markup_transfer_required'),
            'package.required' => __('agent-markup/message.product_markup_package_required'),
            'status.required' => __('product-markup/message.status_required')
        ];
    }
}
