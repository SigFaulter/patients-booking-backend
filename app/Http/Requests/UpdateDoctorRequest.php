<?php

namespace App\Http\Requests;

class UpdateDoctorRequest extends BaseRequest
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
            'full_name' => 'sometimes|string|between:5,50',
            'phone_number' => 'sometimes|string|max:10',
            'city' => 'sometimes|string|max:50',
            'description' => 'sometimes|string|max:255',
            'qualifications' => 'sometimes|string|max:255',
        ];
    }
}
