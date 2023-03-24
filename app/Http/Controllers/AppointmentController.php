<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\RegisterAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    public function index()
    {   
        $user = auth()->user();
        
        if ($user->role === 'doctor') {
            $appointments = Appointment::where('doctor_id', $user->id);
        } else {
            $appointments = Appointment::all();
        }

        if (!$appointments) {
            return response()->json([
                'error' => true,
                'message' => 'No Appointments found',
            ], 404);
        }

        return response()->json($appointments);
    }

    public function show($id)
    {
        $user = auth()->user();

        if ($user->role === 'patient') {
            $appointment = Appointment::where('patient_id', $user->id)->where('id', $id);
        } else {
            $appointment = Appointment::findOrFail($id);
        }

        if ($appointment === null) {
            return response()->json([
                'error' => true,
                'message' => 'Appointment not found',
            ], 404);
        }

        return response()->json($appointment);
    }

    public function store(RegisterAppointmentRequest $request)
    {
        $validated = $request->validated();

        $user = auth()->user();

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

    public function update(UpdateAppointmentRequest $request, $id)
    {
        $validated = $request->validated();

        $user = auth()->user();

        if ($user->role === 'patient') {
            $appointment = Appointment::where('patient_id', $user->id)->where('id', $id);
        } else {
            $appointment = Appointment::findOrFail($id);
        }

        if (!$appointment) {
            return response()->json([
                'error' => true,
                'message' => 'Appointment not found',
            ], 404);
        }

        $appointment->doctor_id = $validated->doctor_id;
        $appointment->appointment_date = $validated->appointment_date;
        $appointment->appointment_time = $validated->appointment_time;

        $appointment->save();

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => $appointment
        ]);
    }

    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->role === 'patient') {
            $appointment = Appointment::where('patient_id', $user->id)->where('id', $id);
        } else {
            $appointment = Appointment::findOrFail($id);
        }

        if (!$appointment) {
            return response()->json([
                'error' => true,
                'message' => 'Appointment not found'
            ], 404);
        }

        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully'
        ], 204);
    }
}
