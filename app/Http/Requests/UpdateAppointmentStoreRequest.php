<?php
namespace App\Http\Requests;

class UpdateAppointmentStoreRequest extends BaseStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can add authorization logic here if needed
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
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'sometimes|nullable|exists:doctors,id',
            'appointment_date' => 'sometimes|nullable|date',
            'appointment_time' => 'sometimes|nullable|string'
        ];
    }
}
