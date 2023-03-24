<?php

namespace App\Http\Requests;

class StoreAvailabilityRequest extends BaseRequest
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
            'doctor_id' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i:s|unique:availability',
            'end_time' => 'required|date_format:H:i:s|after:start_time|unique:availability',
        ];
    }
}
