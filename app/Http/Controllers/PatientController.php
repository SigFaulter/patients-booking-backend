<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        return response()->json([
            'data' => $patients,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:15',
            'city' => 'required|string|max:255',
            'national_id' => 'required|string|max:14|unique:patients',
        ]);

        $patient = Patient::create($validatedData);

        return response()->json([
            'message' => 'Patient created successfully',
            'data' => $patient,
        ], 201);
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        return response()->json([
            'data' => $patient,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'full_name' => 'string|max:255',
            'email' => 'email|unique:patients,email,' . $id,
            'password' => 'string|min:6',
            'phone_number' => 'string|max:15',
            'city' => 'string|max:255',
            'national_id' => 'string|max:14|unique:patients,national_id,' . $id,
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($validatedData);

        return response()->json([
            'message' => 'Patient updated successfully',
            'data' => $patient,
        ]);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json([
            'message' => 'Patient deleted successfully',
        ]);
    }
}
