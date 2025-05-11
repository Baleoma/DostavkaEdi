<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class AuthController extends Controller
{

    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Worng email or password'
            ], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request)
    {
        return User::create($request->all());
    }

    public function logout()
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
