<?php

namespace App\Http\Controllers;
use App\Http\Requests\RateRequest;
use App\Http\Requests\WeightRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\WorkerResource;
use App\Models\EndedOrder;
use App\Models\Order;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\WorkerRequest;


class WorkerController extends Controller
{
    private $companyController;

    public function __construct(CompanyController $companyController)
    {
        $this->companyController = $companyController;
    }
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
        $data['password'] = bcrypt($data['password']);
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

        // encode password and save data
        $row['password'] = bcrypt($row['password']);
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
        $worker = Worker::find(3);

        $raters = $worker->raters;

        //rating equation
        $oldRate = (($worker->rating) * $raters);
        $newRate = (($rateData['behavior'] + $rateData['time']) / 2);
        $rate = (($oldRate + $newRate) / ($raters + 1));

        //insert rating and increment raters by one and return json
        $worker->rating = $rate;
        $worker->raters+= 1;
        $worker->save();

        return response()->json([
           'status' => 'success',
        ], 200);
    }

    public function set_weight(WeightRequest $request): JsonResponse
    {
        $data = $request->validated();

        $worker = auth('worker-api')->user();
        $myOrder = $worker->order;

        // complete order's data and put it in ended_order table
        $data['user_id'] = $myOrder['user_id'];
        $data['worker-id'] = $worker->id;
        $data['order_date'] = date("Y-m-d h-i-s");
        $data['earned_points'] = (int) ($data['weight'] / 3);

        $endedOrder = EndedOrder::create($data);

        $myOrder->delete();

        //  change in the target of worker (my_weight)
        $this->update_target_of_worker($worker, $data['weight']);

        // change in weekly target from admin to worker (weight)
        $this->update_weekly_target_of_admin($this->companyController, $data['worker-id']);

        // add the new points to user's points
        $this->update_points_of_user($data['user_id'], $data['earned_points']);

        return response()->json([
            'order' => new OrderResource($endedOrder),
        ], 201);
    }

    public function update_target_of_worker($worker, $weight)
    {
        $worker->my_weight = (carbon::now() > $worker->end_at) ? $weight : $worker->my_weight + $weight;
        $worker->save();
    }

    public function update_weekly_target_of_admin(CompanyController $companyController, $id)
    {
        $companyController->get_salary($id);
    }

    public function update_points_of_user($id, $pointEarned)
    {
        $user = User::find($id);
        $user->number_of_points += $pointEarned;
        $user->save();
    }
}

