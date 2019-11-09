<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomersUpdateRequest extends FormRequest
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
            'phone_number' => 'required|max:15',
            'email' => 'required|string|email|max:255',
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'marriage_date' => 'required|date',
            'active' => 'required',
            'gender' => 'required',
            'cust_code' => 'required',
            'photo_id' => 'mimes:jpeg,png|dimensions:min_width=300,min_height=300',
            'person_image'=>'mimes:jpeg,png|dimensions:min_width=300,min_height=200'
        ];
    }
}
