<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
   public function get_points(): \Illuminate\Http\JsonResponse
   {
       // we must change this line later by auth
       $user = User::find(3);
       return response()->json([
           'points' => $user->number_of_points,
       ], 200);
   }

   public function prize(): \Illuminate\Http\JsonResponse
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
}
