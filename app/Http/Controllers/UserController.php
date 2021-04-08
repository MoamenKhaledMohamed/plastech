<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

   public function prize(): JsonResponse
   {
       $user = auth('user-api')->user();
       $myPoints = $user->number_of_points;

        // my equation to convert points to money and select appropriate products
        $myMoney = (int) ($myPoints / 3);
        $products = Product::where('price', '<=', $myMoney)->get();
        if (count($products) !== 0)
           return response()->json([
               'products' => ProductResource::collection($products)
           ], 200);

        return response()->json([
           'product not found'
        ], 404);
   }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UserRequest $request): JsonResponse
    {
        $updatedUser = $request->validated();
        $user = auth('user-api')->user();

        // updating data
        foreach ($updatedUser as $key => $value) {
            $user->$key = $value;
        }

        // encode password and save data
        $user['password'] = bcrypt($user['password']);
        $user->save();

        return response()->json([
            'user' => new UserResource($user)
        ], 201);

    }


}
