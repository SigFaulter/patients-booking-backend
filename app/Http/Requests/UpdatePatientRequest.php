<?php

namespace App\Http\Requests;

class UpdatePatientRequest extends BaseRequest
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
            'full_name' => 'sometimes|string|min:3|max:50',
            'phone_number' => 'sometimes|string|max:10',
            'id_card' => 'sometimes|string|max:50|unique:patients',
            'birthday' => 'required|date'
        ];
    }
}
