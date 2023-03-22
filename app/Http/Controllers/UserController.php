<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    public function getUser()
    {
        $user = Auth::user();

        return response()->json(['user' => $user]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        // TODO make it update the patient details and user table at the same time
        $validated = $request->validated();

        $user = User::find($validated['id']);
        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found'
            ], 404);
        }

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], 201);
    }

    public function deleteUser()
    {
        $user = Auth::user();
        // TODO delete related records in patients table
        // $user->delete();

        // TODO redirect user to logout to get out
        // OR make the app do so
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 200)->withCookie(cookie('token', '', 1, null, null, false, true));
    }
}
?>