<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
class RegisterDoctorRequest extends BaseRequest
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
            'full_name' => 'required|string|between:5,50',
            'phone_number' => 'required|string|max:10',
            'city' => 'required|string|max:50'
        ];
    }


}
