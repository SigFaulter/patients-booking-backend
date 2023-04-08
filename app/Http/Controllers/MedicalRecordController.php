<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

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

    /*
    public function store(Request) {

    }
    */
}
