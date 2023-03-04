<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $appointment = new Appointment;
        $appointment->patient_id = $request->patient_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->save();

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment
        ]);
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
        ]);
    }
}
