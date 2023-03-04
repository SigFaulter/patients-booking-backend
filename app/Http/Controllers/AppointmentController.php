<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Http\Requests\RegisterAppointmentStoreRequest;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    public function show($id)
    {
        $appointment = Appointment::find($id);
        return response()->json($appointment);
    }

    public function store(RegisterAppointmentStoreRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $appointment = new Appointment([
            'patient_id' => $user->id,
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
        ]);

        $appointment->save();

        return response()->json([
            'message' => 'Appointment created successfully'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        $appointment->patient_id = $request->patient_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->save();

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => $appointment
        ]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully'
        ], 204);
    }
}
