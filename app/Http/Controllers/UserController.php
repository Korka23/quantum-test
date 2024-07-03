<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($validated)){
            $user = User::query()->where('email', $validated['email'])->first();
            return response()->json([
                'message' => 'User logged in Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        };

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $user = User::query()->create($validated);

        return response()->json([
            'message' => 'User Created Successfully' ,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}