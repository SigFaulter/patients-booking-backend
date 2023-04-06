<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Doctor;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User([
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->save();

        $user = User::where('email', $validated['email'])->first();

        $patient = new Patient($validated);
        $patient->patient_id = $user->id;

        try {
            $patient->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'User created successfully!',
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password']
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => true, 'message' => 'Invalid Credentials'], 401);
        }

        $user = Auth::user();

        if ($user->role == 'patient') {
            $data = Patient::where('patient_id', $user->id)->firstOrFail();
        } else if ($user->role == 'doctor') {
            $data = Doctor::where('doctor_id', $user->id)->firstOrFail();
        }

        return response()->json([
            'error' => false,
            'message' => 'Login successful!',
            'user' => $user,
            $user->role => $data,
            'Authorization' => 'Bearer ' . $token
        ], 200)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Access-Control-Expose-Headers' => 'Authorization',
        ]);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();

        $user = auth()->user();

        if ($user->role === 'patient') {
            $user = User::where('patient_id', $user->id)->where('id', $id);
        } else {
            $user = User::findOrFail($id);
        }

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ], 404);
        }

        $user->email = $validated->email;
        $user->full_name = $validated->full_name;
        $user->password = $validated->password;

        try {
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException) {
            return response()->json(['error' => true,
                'message' => 'Could not invalidate token'
            ], 500);
        }

        return response()->json(['error' => false, 'message' => 'Successfully logged out'], 200);
    }
}