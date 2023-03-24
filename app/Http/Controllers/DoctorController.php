<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);

        if (!$doctor) {
            return response()->json([
                'error' => true,
                'message' => 'Doctor not found',
            ], 404);
        }

        return response()->json($doctor);
    }

    public function store(Request $request)
    {
        $validated = $request->validated();

        $doctor = new Doctor([
            'full_name' => $validated['full_name'],
            'phone_number' => $validated['phone_number'],
            'city' => $validated['city'],
        ]);

        $doctor->save();

        return response()->json([
            'error' => false,
            'message' => 'Doctor created successfully',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role != 'admin') {
            if ($user->id != $id) {
                return response()->json([
                    'error' => true,
                    'message' => 'Forbidden',
                ], 403);
            }
        }

        $validated = $request->validated();

        $doctor = Doctor::findOrFail($id);

        if (!$doctor) {
            return response()->json([
                'error' => true,
                'message' => 'Doctor not found',
            ], 404);
        }

        $doctor->full_name = $validated['full_name'];
        $doctor->phone_number = $validated['phone_number'];
        $doctor->city = $validated['city'];
        $doctor->qualifications = $validated['qualifications'];
        $doctor->description = $validated['description'];

        $doctor->save();

        return response()->json([
            'error' => false,
            'message' => 'Doctor updated successfully',
            'doctor' => $doctor
        ], 200);
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        if (!$doctor) {
            return response()->json([
                'error' => true,
                'message' => 'Doctor not found',
            ], 404);
        }

        $doctor->delete();

        return response()->json([
            'error' => false,
            'message' => 'Doctor deleted successfully'
        ], 201);
    }
}
