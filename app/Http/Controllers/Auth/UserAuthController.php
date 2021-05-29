<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function register(UserRequest $request): \Illuminate\Http\JsonResponse
    {
        echo(88888888);
        $credentials = $request->validated();
        echo(999999999);
        $credentials['password'] = bcrypt($credentials['password']);

        $user = User::create($credentials);
        $token = $user->createToken('UserAuthToken')->accessToken;

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token
        ], 201);
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validated();

        // check on email and password in users table by attempt() Note this method in guard session
        if(!auth('user')->attempt($credentials))
            return response()->json(['error' => 'Unauthorised'], 401);

        $user = auth('user')->user();
        $token = $user->createToken('UserAuthToken')->accessToken;

        return response()->json([
        'user' => new UserResource($user),
        'access_token' => $token
        ], 200);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        // get the authenticated user from helper method auth() Note:: here we used guard passport
        $user = auth('user-api')->user();
        $user->tokens()->delete();

        return response()->json([
            'user' => 'logout'
        ], 200);
    }

}
 