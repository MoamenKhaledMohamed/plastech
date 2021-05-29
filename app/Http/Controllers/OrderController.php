<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LocationRequest as LocationRequest;
use function PHPUnit\Framework\isEmpty;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function update(Request $request, Order $order): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return Response
     */
    public function destroy(Order $order): Response
    {
        //
    }

    public function search_for_my_order(LocationRequest $request,MapController $mapController): JsonResponse
    {
        //get authenticated worker
        $worker = auth('worker-api')->user();
        //call methode to store his location in database
        $mapController->change_my_location($request);
        //check if there is any order from client and return the result in json
        $result = Order::where('worker_id','=', $worker->id)->get();
        if(count($result) !== 0){

           return response()->json([
                'Order' => OrderResource::collection($result)
            ], 200);
        }
        else{ return response()->json([
            'Order' => 'No current orders yet'
        ], 200);}


    }


}
