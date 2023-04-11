<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicalRecordRequest;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePatientRequest;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'patient') {
            $records = MedicalRecord::where('patient_id', $user->id)->firstOrFail();
        } else {
            $records = MedicalRecord::findOrFail($user->id);
        }

        return response()->json($records);
    }

    public function store(StoreMedicalRecordRequest $request) {
        $validated = $request->validated();

        $record = new MedicalRecord($validated);

        try {
            return $record->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}