<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        function getBytesFromHexString($hexdata)
        {
        for($count = 0; $count < strlen($hexdata); $count+=2)
            $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

        return implode($bytes);
        }

        function getImageMimeType($imagedata)
        {
        $imagemimetypes = array(
            "jpeg" => "FFD8",
            "png" => "89504E470D0A1A0A",
            "gif" => "474946",
        );

        foreach ($imagemimetypes as $mime => $hexbytes)
        {
            $bytes = getBytesFromHexString($hexbytes);
            if (substr($imagedata, 0, strlen($bytes)) == $bytes)
            return $mime;
        }

        return NULL;
        }

        $validated = $request->validated();

        $patient = Patient::findOrFail($id);

        if (!$patient) {
            return response()->json([
                'error' => true,
                'message' => 'Patient not found'
            ], 404);
        }

        if ($request->has('image')) {
            $image = base64_decode($request->image);

            $mime = getImageMimeType($image);
            $allowedExtensions = ['jpeg', 'png', 'gif'];

            if (!in_array($mime, $allowedExtensions)) {
                return response()->json(['error' => true, 'message' => 'Invalid file type'], 400);
            }

            // Generate a unique name for the file
            $file_name = Str::random(15) . ".$mime";

            // Move the uploaded file to the public directory
            Storage::disk('public')->put($file_name, $image);

            // Save the file name to the user's profile
            $patient['image'] = $file_name;
        }

        try {
            $patient->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

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
