<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientStoreRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'patient') {
            return response()->json([
                'error' => true,
                'message' => 'Forbidden',
            ], 403);
        }

        $patients = Patient::all();

        return response()->json([$patients]);
    }

    public function store(StorePatientStoreRequest $request)
    {
        $validated = $request->validated();

        $patient = Patient::create($validated);

        return response()->json([
            'message' => 'Patient created successfully',
            'data' => $patient,
        ], 201);
    }

    public function show($id)
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

        $patient = Patient::findOrFail($id);

        if (!$patient) {
            return response()->json([
                'error' => true,
                'message' => 'Patient not found'
            ], 404);
        }

        return response()->json([
            'data' => $patient,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $validated = $request->validated();

        if ($user->role != 'admin') {
            if ($user->id != $id) {
                return response()->json([
                    'error' => true,
                    'message' => 'Forbidden',
                ], 403);
            }
        }

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
        $user = Auth::user();

        if ($user->role != 'admin') {
            if ($user->id != $id) {
                return response()->json([
                    'error' => true,
                    'message' => 'Forbidden',
                ], 403);
            }
        }
        
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
        ], 200);
    }
}
