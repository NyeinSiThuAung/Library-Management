<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registers a new user.
     *
     * This method handles user registration, assigns a role to the new user,
     * and generates an authentication token.
     *
     * @param  RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $request->except('role');
        $userRole = $request->only('role')['role'];

        $user = User::create($user);

        $user->assignRole($userRole);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
        ], 201);
    }

    /**
     * Logs in an existing user.
     *
     * This method authenticates a user based on their email and password.
     * If authentication is successful, a token is generated and returned.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User login successfully',
            'token' => $token,
        ], 200);
    }
}
