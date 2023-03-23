<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientStoreRequest extends BaseStoreRequest
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
            'full_name' => 'string|max:50',
            'email' => 'email|unique:users',
            'password' => 'string|min:8',
            'phone_number' => 'string|max:10',
            'city' => 'string|max:50',
            'id_card' => 'string|<max:10></max:10>|unique:patients',
        ];
    }
}
