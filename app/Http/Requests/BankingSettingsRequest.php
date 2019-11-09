<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankingSettingsRequest extends FormRequest
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
            'b_name' => 'required|string|max:255',
            'b_name_en' => 'required|string|max:255',
            'bank_type' => 'required|not_in:0',
            'active' => 'required',
        ];
    }
}
