<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Http\Requests\UpdateAvailabilityStoreRequest;
use App\Http\Requests\StoreAvailabilityStoreRequest;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availability = Availability::all();
        return response()->json($availability);
    }

    public function store(StoreAvailabilityStoreRequest $request)
    {
        $validated = $request->validated();

        $availability = Availability::create($validated);

        return response()->json([
            'error' => false,
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

    public function update(UpdateAvailabilityStoreRequest $request, $id)
    {
        $validated = $request->validated();

        $availability = Availability::findOrFail($id);
        
        if ($availability === null) {
            return response()->json([
                'error' => true,
                'message' => 'Availability not found',
            ], 404);
        }

        $availability->update($validated);

        return response()->json([
            'error' => false,
            'message' => 'Availability updated successfully',
            'data' => $availability,
        ]);
    }

    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);
        $availability->delete();

        return response()->json([
            'error' => false,
            'message' => 'Availability deleted successfully',
        ], 201);
    }
}
