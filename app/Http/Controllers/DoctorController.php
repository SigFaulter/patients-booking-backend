<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
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
        $user = Auth::user();

        if ($user->role === 'doctor') {
            $doctor = Doctor::where('doctor_id', $id);
        } else {
            $doctor = Doctor::findOrFail($id);
        }

        if (!$doctor) {
            return response()->json([
                'error' => true,
                'message' => 'Doctor not found',
            ], 404);
        }

        return response()->json($doctor, 200);
    }

    public function store(RegisterDoctorRequest $request)
    {
        $validated = $request->validated();

        $doctor = new Doctor([
            'full_name' => $validated['full_name'],
            'phone_number' => $validated['phone_number'],
            'city' => $validated['city'],
        ]);

        try {
            $doctor->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Doctor created successfully',
        ], 200);
    }

    public function update(UpdateDoctorRequest $request, $id)
    {
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

        try {
            $doctor->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

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

        /*try {
            // TODO delete all related records
            // $doctor->delete();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }*/

        return response()->json([
            'error' => false,
            'message' => 'Doctor deleted successfully'
        ], 204);
    }
}
