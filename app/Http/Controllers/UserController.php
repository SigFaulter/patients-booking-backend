<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json($user);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json($user);
    }

    // TODO handle pfp upload
    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found'
            ], 404);
        }

        $user = new User($validated);
        
        if ($request->has('pfp')) {
            $image = base64_decode($request->pfp);
        
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($validated['pfp_file_name'], PATHINFO_EXTENSION);

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json(['error' => true, 'message' => 'Invalid file type'], 400);
            }

            // Generate a unique name for the file
            $file_name = Str::random(40) . '.' . $request->pfp_name;

            // Move the uploaded file to the public directory
            Storage::disk('public')->put($file_name, $image);

            // Save the file name to the user's profile
            $user['pfp'] = $file_name;
        }

        try {
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], 201);
    }

    public function store(RegisterUserRequest $request) {
        $validated = $request->validated();

        $user = new User($validated);
        
        try {
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function destroy($id)    
    {
        // TODO delete related records in patients table
        //User::delete($id);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 204)->withCookie(cookie('token', '', 1, null, null, false, true));
    }
}
?>