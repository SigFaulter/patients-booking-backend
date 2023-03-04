<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    public function show($id)
    {
        $doctor = Doctor::find($id);
        return response()->json($doctor);
    }

    public function store(Request $request)
    {
        $validated = $request->validated();

        $doctor = new Doctor([
            'full_name' => $validated['full_name'],
            'phone_number' => $validated['phone_number'],
            'city' => $validated['city'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        $doctor->save();

        return response()->json([
            'success' => true,
            'message' => 'Doctor created successfully',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validated();

        $doctor = Doctor::find($id);

        $doctor->full_name = $validated['full_name'];
        $doctor->phone_number = $validated['phone_number'];
        $doctor->city = $validated['city'];
        $doctor->email = $validated['email'];

        $doctor->save();

        return response()->json([
            'success' => true,
            'message' => 'Doctor updated successfully',
            'doctor' => $doctor
        ], 200);
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully'
        ], 204);
    }
}
