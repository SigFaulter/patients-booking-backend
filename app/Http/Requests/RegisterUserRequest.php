<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseStoreRequest;

class RegisterUserRequest extends BaseStoreRequest
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
            'name' => 'required|string|between:5,255',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:8,255'
        ];
    }


}
