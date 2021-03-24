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
   public function get_points(): JsonResponse
   {
       // we must change this line later by auth
       $user = User::find(3);
       return response()->json([
           'points' => $user->number_of_points,
       ], 200);
   }

   public function prize(): JsonResponse
   {
        $myPoints = $this->get_points()->original['points'];

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
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $row = User::find($id);
        return response()->json([
            'user' => new UserResource($row),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UserRequest $request, $id): JsonResponse
    {
        //validate worker data
        $data = $request->validated();

        $row = User::find($id);

        // updating data
        foreach ($data as $key => $value) {
            $row->$key = $value;
        }
        // save data
        $row->save();
        return response()->json([
            'user' => new UserResource($row)
        ], 201);

    }


}
