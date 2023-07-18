<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Interface\UserInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private UserInterface $user)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 403,
                'message' => 'Email or password incorrect',
            ], 403);
        }

        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expire_in' => Carbon::now()->addHours(2)->toDateTimeString(),
        ]);
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];

        $user = $this->user->store($data);

        return response()->json([
            'status' => 201,
            'message' => 'You have successed register!',
            'data' => $user,
        ], 201);
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'access_token' => Auth::refresh(),
            'token_type' => 'bearer',
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::invalidate(true);
        Auth::logout(true);

        return response()->json([
            'status' => 200,
            'message' => 'Successed log out!',
        ]);
    }
}
