<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

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
        $user = auth()->user();

        if ($user->role != 'admin') {
            if ($user->id != $id) {
                return response()->json([
                    'error' => true,
                    'message' => 'Forbidden',
                ], 403);
            }
        } 

        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();
        $user = Auth::user();

        if ($user->role != 'admin') {
            if ($user->id != $id) {
                return response()->json([
                    'error' => true,
                    'message' => 'Forbidden',
                ], 403);
            }
        }
        
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found'
            ], 404);
        }

        $user = new User([
            'email' => $validated['email'],
            'password' => $validated['password']
        ]);

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], 201);
    }

    public function delete($id)
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

        // TODO delete related records in patients table
        //User::delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 200)->withCookie(cookie('token', '', 1, null, null, false, true));
    }
}
?>