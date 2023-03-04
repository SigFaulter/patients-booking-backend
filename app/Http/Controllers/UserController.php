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
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function deleteUser()
    {
        $user = Auth::user();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'])
            ->withCookie(cookie('token', '', 1, null, null, false, true));
    }
}
?>