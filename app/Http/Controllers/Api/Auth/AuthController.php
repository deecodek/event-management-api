<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'auth_id' => 'required|string|unique:users,auth_id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'auth_id' => $request->auth_id,
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Generate a token for the user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'auth_id' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->where('auth_id', $request->auth_id)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'email' => $user->email,
            'device_name' => $request->device_name,
        ]);
    }

    /**
     * Logout the user (revoke the token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Get the authenticated user.
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
