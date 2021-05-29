<?php

namespace App\Http\Controllers;
use App\Http\Requests\LocationRequest as LocationRequest;
use App\Http\Controllers\OrderController as OrderController;
use Illuminate\Http\JsonResponse;

class MapController extends Controller
{
    private $mapController;
    // User Part


    public function get_order(float $latitude, float $longitude): JsonResponse
    {
        // validation latitude and longitude.

        // insert latitude and longitude in user's table.

        // return available locations of workers. search in table and check on status of worker.
        $availableWorkers = $this->get_available_workers($latitude, $longitude);

        // return the nearest worker.
        $worker = $this->get_the_nearest_worker($availableWorkers, $latitude, $longitude);

        // insert in order's table
        $this->create_order($worker);

        // return worker's data to user as json.
        return response()->json([]);
    }

    public function get_available_workers(float $latitude, float $longitude): array
    {
        // return array of workers by query.
        return [];
    }

    public function get_the_nearest_worker($availableWorkers, float $latitude, float $longitude): string
    {
        // compare locations of available workers to location of user then return this worker.
        // use distance matrix.
        // add duration and distance to worker's table.
        // get the nearest worker by less duration or distance.
        // return this worker.
       return '';
    }

    public function create_order($worker)
    {
        // create order in order's table.
    }

    // Worker Part

    /**
     */

    public function change_my_location (LocationRequest $request){
        //check validate and then store longitude, latitude and status of current worker
        $request->validated();
        $worker = auth('worker-api')->user();
        $worker->latitude = $request['latitude'];
        $worker->longitude = $request['longitude'];
        $worker->status = $request['status'];
        $worker->save();
    }

}
