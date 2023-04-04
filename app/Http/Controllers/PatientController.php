<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'patient') {
            $patients = Patient::where('patient_id', $user->id)->first();
        } else {
            $patients = Patient::all();
        }

        return response()->json($patients, 200);
    }

    public function store(StorePatientRequest $request)
    {
        $validated = $request->validated();

        try {
            $patient = Patient::create($validated);

            return response()->json([
                'error' => false,
                'message' => 'Patient created successfully',
                'data' => $patient,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $patient = Patient::where('patient_id', $id)->firstOrFail();

        if (!$patient) {
            return response()->json([
                'error' => true,
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json($patient);
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        $validated = $request->validated();

        $patient = Patient::findOrFail($id);

        if (!$patient) {
            return response()->json([
                'error' => true,
                'message' => 'Patient not found'
            ], 404);
        }

        $patient->update($validated);

        return response()->json([
            'message' => 'Patient updated successfully',
            'data' => $patient,
        ], 200);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);

        if (!$patient) {
            return response()->json([
                'error' => true,
                'message' => 'Patient not found'
            ], 404);
        }

        // TODO delete all related records
        // $patient->delete();

        return response()->json([
            'error' => false,
            'message' => 'Patient deleted successfully',
        ], 204);
    }
}
