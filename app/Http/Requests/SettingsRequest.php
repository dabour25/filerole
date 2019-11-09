<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'internal_item' => 'required',
            /*'business_logo_dark' => 'mimes:png',
            'business_logo_light' => 'mimes:png',
            'cover' => 'mimes:jpeg',
            'contact_email' => 'email'*/
        ];
    }

    public function messages()
    {
        return [
            'internal_item.mimes' => 'يجب اختيار نوع الاستخدام الداخلى للاصناف'
            /*'business_logo_dark.mimes' => __('backend.select_png'),
            'business_logo_light.mimes' => __('backend.select_png'),
            'cover.mimes' => __('backend.select_jpg')*/
        ];
    }
}
