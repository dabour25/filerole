<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersUpdateRequest extends FormRequest
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
            //'code' => 'required',
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'phone_number' => 'required|max:15',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string|max:255',
            //'birthday' => 'required|date',
            'is_active' => 'required',
            'role_id' => 'required|not_in:0',
            //'section_id' => 'required|not_in:0',
            'photo_id' => 'mimes:jpeg,png'
        ];
    }
}
