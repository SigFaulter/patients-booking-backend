<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class DoctorRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|between:5,50',
            'phone_number' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|max:255',
        ];
    }
}
