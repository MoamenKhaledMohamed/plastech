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

    public function search_for_my_order(): JsonResponse
    {
        //get authenticated worker
        $worker = auth('worker-api')->user();

        //check if there is any order from client and return the result in json
        $result = Order::where('worker_id','=', $worker->id)->get();
        $user = $result[0]->user;

        if(count($result) !== 0)
           return response()->json([
                'Order' => $result[0],
           ], 200);


        return response()->json([
                'Order' => 'No current orders yet'
        ], 200);


        // get one order
        // return user's info (name, location).
        // handle if found more than order.

    }


}
