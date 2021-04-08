<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AdminResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAuthController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validated();

        // check on email and password in admins table by attempt() Note this method in guard session
        if(!auth('admin')->attempt($credentials))
            return response()->json(['error' => 'Unauthorised'], 401);

        $admin = auth('admin')->user();
        $token = $admin->createToken('AdminAuthToken')->accessToken;

        return response()->json([
            'admin' => new AdminResource($admin),
            'access_token' => $token
        ], 200);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        // get the authenticated admin from helper method auth() Note:: here we used guard passport
        $admin = auth('admin-api')->user();
        $admin->tokens()->delete();

        return response()->json([
            'admin' => 'logout'
        ], 200);
    }
}
