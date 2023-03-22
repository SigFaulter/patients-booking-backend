<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseStoreRequest;
class RegisterDoctorStoreRequest extends BaseStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|between:5,255',
            'phone_number' => 'required|email|unique:users',
            'city' => 'required|between:4,255'
        ];
    }


}