<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\WorkerResource;
use Illuminate\Http\Request;

class WorkerAuthController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validated();

        // check on email and password in workers table by attempt() Note this method in guard session
        if(!auth('worker')->attempt($credentials))
            return response()->json(['error' => 'Unauthorised'], 401);

        $worker = auth('worker')->user();
        $token = $worker->createToken('WorkerAuthToken')->accessToken;

        return response()->json([
            'worker' => new WorkerResource($worker),
            'access_token' => $token
        ], 200);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        // get the authenticated worker from helper method auth() Note:: here we used guard passport
        $worker = auth('worker-api')->user();
        $worker->tokens()->delete();

        return response()->json([
            'worker' => 'logout'
        ], 200);
    }
}
