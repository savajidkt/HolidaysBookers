<?php

namespace App\Http\Requests\ProductMarkup;

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
            'name'        => ['required'],
            'percentage'        => ['required'],
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
            'name.required' => __('product-markup/message.product_markup_name_required'),
            'percentage.required' => __('product-markup/message.product_markup_percentage_required'),
            'status.required' => __('product-markup/message.status_required')
        ];
    }
}
