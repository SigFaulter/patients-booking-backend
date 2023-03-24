<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class RegisterUserRequest extends BaseRequest
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
            'fullname' => 'required|string|min:5|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'string|min:8|confirmed',
            'password2' => 'string|min:8',
            'phone_number' => 'string|max:10',
        ];
    }


}
