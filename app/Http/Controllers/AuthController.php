<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $credentials = [
            "email" => $validatedData["email"],
            "password" => $validatedData["password"]
        ];

        // $token = auth()->attempt($credentials);
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                "status" => "error",
                "message" => "Unauthorized"
            ], 401);
        }

        return response()->json(
            [
                "status" => "success",
                // "user" => auth()->user(),
                "user" => Auth::user(),
                "authorization" => [
                    "token" => $token,
                ]
            ]
        );
    }

    public function refresh(Request $request)
    {
        return response()->json([
            "status" => "success",
            "user" => auth()->user(),
            "authorization" => [
                "token" => auth()->refresh()
            ]
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            "status" => "success",
        ]);
    }

    public function register(RegisterRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::create([
            "first_name" => $validatedData["first_name"],
            "last_name" => $validatedData["last_name"],
            "email" => $validatedData["email"],
            "password" => Hash::make($validatedData["password"]),
            "accepted_terms" => $validatedData["accepted_terms"]
        ]);

        $token = auth()->login($user);
        return response()->json([
            "status" => "success",
            "user" => $user,
            "authorization" => ["token" => $token]
        ]);
    }
}
