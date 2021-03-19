<?php

namespace App\Http\Controllers;
use App\Http\Resources\WorkerResource;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\WorkerRequest;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;


class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //retrieving workers data from database
        $rows = Worker::all();
        //return retrieved  workers data encoded in json
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
        //validate worker data
        $data = $request->validated();
        //insert validated data in database
        $row = Worker::create($data);
        //return data encoded in json
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
        //return worker data with its specific id in json format

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
            $results = Worker::where('first_name', 'like','%'. $keyword .'%')->get();
            if ($results->toarray() !== null)
                //return result of id search
                return response()->json([
                    'Worker' => WorkerResource::collection($results)
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

        return response()->json([], 200);
    }

}

