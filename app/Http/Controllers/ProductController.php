<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): JsonResponse
    {
        //$products = Product::all();
        return response()->json([
            'data' => ProductResource::collection(Product::paginate())
        ], 200);
    }

    public function search($key): JsonResponse
    {
        $results = [];
        if (is_numeric($key)) {
            $results = Product::where('price', '=', $key)->get();
            if (count($results) !== 0)
                return response()->json([
                    'product' => ProductResource::collection($results)
                ], 200);

        } else {
            $results = Product::where('name', 'like','%'. $key .'%')->get();
            if (count($results) !== 0)
                return response()->json([
                    'products' => ProductResource::collection($results)
                ], 200);
        }

        if(count($results) === 0)
            return response()->json([
                'product not found'
            ], 404);
    }

    public function checkout()
    {
        // steps for payment with paypal (or any thing)
    }
}
