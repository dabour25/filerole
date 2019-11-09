<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'type' => 'required',
            'categories_type' => 'required',
            'name' => 'required',
            'name_en' => 'required',
            'name_en' => 'required',
            'photo_id' => 'required|mimes:jpeg,png'
        ];
    }
}
