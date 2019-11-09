<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxSettingsRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'tax_type' => 'required|not_in:0',
            'active' => 'required',

            'percent' => 'required_if:tax_type,2',
            //'value' => 'required_if:tax_type,1',
        ];
    }
}
