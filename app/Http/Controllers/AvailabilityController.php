<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availabilities = Availability::all();

        return response()->json([
            'data' => $availabilities,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
        ]);

        $availability = Availability::create($validatedData);

        return response()->json([
            'message' => 'Availability created successfully',
            'data' => $availability,
        ], 201);
    }

    public function show($id)
    {
        $availability = Availability::findOrFail($id);

        return response()->json([
            'data' => $availability,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'integer',
            'date' => 'date_format:Y-m-d',
            'start_time' => 'date_format:H:i:s',
            'end_time' => 'date_format:H:i:s|after:start_time',
        ]);

        $availability = Availability::findOrFail($id);
        $availability->update($validatedData);

        return response()->json([
            'message' => 'Availability updated successfully',
            'data' => $availability,
        ]);
    }

    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);
        $availability->delete();

        return response()->json([
            'message' => 'Availability deleted successfully',
        ]);
    }
}
