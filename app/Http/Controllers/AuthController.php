<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;

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

        return response()->json([
            'error' => false,
            'message' => 'Login successful!',
            'user' => $user,
            'Authorization' => 'Bearer ' . $token
        ], 200)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Access-Control-Expose-Headers' => 'Authorization',
        ]);
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