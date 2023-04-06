<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $doctor = Doctor::findOrFail($id);


        if (!$doctor) {
            return response()->json([
                'error' => true,
                'message' => 'Doctor not found',
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
            $doctor['image'] = $file_name;
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
