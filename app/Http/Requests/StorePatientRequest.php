<?php

namespace App\Http\Requests;

class StorePatientRequest extends BaseRequest
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
            'full_name' => 'required|string|min:3|max:50',
            'phone_number' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'id_card' => 'required|string|max:50|unique:patients',
        ];
    }
}
