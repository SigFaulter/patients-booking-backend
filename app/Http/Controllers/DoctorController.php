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
        $doctor = new Doctor;
        $doctor->full_name = $request->full_name;
        $doctor->phone_number = $request->phone_number;
        $doctor->city = $request->city;
        $doctor->user_id = $request->user_id;
        $doctor->save();

        return response()->json([
            'message' => 'Doctor created successfully',
            'doctor' => $doctor
        ]);
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        $doctor->full_name = $request->full_name;
        $doctor->phone_number = $request->phone_number;
        $doctor->city = $request->city;
        $doctor->user_id = $request->user_id;
        $doctor->save();

        return response()->json([
            'message' => 'Doctor updated successfully',
            'doctor' => $doctor
        ]);
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();

        return response()->json([
            'message' => 'Doctor deleted successfully'
        ]);
    }
}
