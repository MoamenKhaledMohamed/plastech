<?php

namespace App\Http\Controllers;
use App\Http\Requests\RateRequest;
use App\Http\Requests\WeightRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\WorkerResource;
use App\Models\Order;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\WorkerRequest;


class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $rows = Worker::all();
        return response()->json([
            'worker'  => WorkerResource::collection($rows),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WorkerRequest $request
     * @return JsonResponse
     */
    public function store(WorkerRequest $request): JsonResponse
    {
        $data = $request->validated();
        $row = Worker::create($data);
        return response()->json([
            'worker' => new WorkerResource($row),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $row = Worker::find($id);
        return response()->json([
            'worker' => new WorkerResource($row),
        ], 200);
    }



    /**
     * Show the the result for searching on a resource.
     *
     * @param $keyword
     * @return JsonResponse
     */
    public function search($keyword): JsonResponse
    {
        $result = null;
        //check weather searching by (first name) keyword or by id
        if (is_numeric($keyword)) {
            $result = Worker::find($keyword);
            //check if search result found or not
            if ($result !== null)
                return response()->json([
                    'Worker' => new WorkerResource($result)
                ], 200);

        } else {
            $result = Worker::where('first_name', 'like','%'. $keyword .'%')->get();
            if (count($result) !== 0)
                //return result of id search
                return response()->json([
                    'Worker' => WorkerResource::collection($result)
                ], 200);
        }

        if($result === null || count($result) === 0)
            return response()->json([
                'Worker not found'
            ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WorkerRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(WorkerRequest $request, $id): JsonResponse
    {
        //validate worker data
        $data = $request->validated();

        $row = Worker::find($id);

        // updating data
        foreach ($data as $key => $value) {
            $row->$key = $value;
        }
        // save data
        $row->save();
        return response()->json([
            'Worker' => new WorkerResource($row)
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        //delete existing worker
        Worker::destroy($id);

        return response()->json(['worker was deleted'], 200);
    }

    /**
     * store specified worker rate in storage.
     *
     * @param RateRequest $request
     * @return JsonResponse
     */
    public function set_rate(RateRequest $request): JsonResponse
    {
        $rateData = $request->validated();

        //note:this line should replaced with worker algorithm
        $row = Worker::find(3);

        $raters = $row->raters;

        //rating equation
        $oldRate = (($row->rating) * $raters);
        $newRate = (($rateData['behavior'] + $rateData['time']) / 2);
        $rate = (($oldRate + $newRate) / ($raters + 1));

        //insert rating and increment raters by one and return json
        $row->rating = $rate;
        $row->raters+= 1;
        $row->save();
        return response()->json([
           'Worker' => new WorkerResource($row),
        ], 201);
    }

    public function set_weight(WeightRequest $request): JsonResponse
    {
        /*
         * insert row in orders'table
         * id of client by algorithm
         * weight by request
         * id of worker by auth
         * points by equation
         * date of order by the current date
         */
        $data = $request->validated();
        $data['order_date'] = date("Y-m-d h-i-s");
        $data['point_earned'] = (int) ($data['weight'] / 3);
        $data['user_id'] = 3;
        $data['worker_id'] = 2;
        $order = Order::create($data);

        return response()->json([
            'order' => new OrderResource($order),
        ], 201);
    }
}

