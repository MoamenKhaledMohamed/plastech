<?php

namespace App\Http\Controllers;
use App\Http\Requests\LocationRequest as LocationRequest;
use App\Http\Controllers\OrderController as OrderController;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Worker;
use App\Models\Order;
use App\Http\Resources\WorkerResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    private $mapController;
    // User Part


    public function get_order(LocationRequest $request): JsonResponse
    {
        // validation latitude and longitude.
        $data = $request->validated();
        $user = auth('user-api')->user();

        // insert latitude and longitude in user's table.
        // $user_DB = User::find($user->id);
        $user->latitude = $data['latitude'];
        $user->longitude = $data['longitude'];
        $user->save();
        
        // return 10 available locations of workers. search in table and check on status of worker.
        $availableWorkers = $this->get_available_workers($data['latitude'], $data['longitude']);
        // return nearst one
        $nearestWorker = $this->get_the_nearest_worker($availableWorkers, $data['latitude'], $data['longitude']);
        // insert in order's table
        $this->create_order($user->id, $nearestWorker->id);

        // return worker's data to user as json.
        return response()->json([
            'nearestWorker'  =>  $nearestWorker,
        ], 200);
    }

    public function get_available_workers(float $latitude, float $longitude)
    {
        // SELECT id,
        //     3956 * 2 * ASIN(
        //             SQRT( POWER(SIN(ABS(31.264807 - latitude) * pi()/180 / 2), 2)
        //                 + COS(30.010371 * pi()/180 ) * COS(latitude * pi()/180)
        //                         * POWER(SIN(ABS(30.010371 - longitude) * pi()/180 / 2), 2) ))
        //         AS distance
        // from workers
        // order by distance;

        // return 10 available locations of workers. search in table and check on status of worker.
        // $workers = Worker::select('id', 'latitude','longitude', DB::raw('sqrt( ( pow(latitude - '.$latitude.', 2) + pow((longitude - '.$longitude.'), 2) ) ) as val1'))
        //     ->where('status', 1)
        //     ->groupBy('id')
        //     ->orderBy('val1')
        //     ->limit(10)
        //     ->get();
        $workers = Worker::select('id', 'latitude','longitude', DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(ABS('.$latitude.' - latitude) * pi()/180 / 2), 2) + COS('.$longitude.' * pi()/180 ) * COS(latitude * pi()/180) * POWER(SIN(ABS('.$longitude.' - longitude) * pi()/180 / 2), 2) ))AS distance'))
            ->where('status', 1)
            ->orderBy('distance')
            ->limit(10)
            ->get();

        Log::error($workers);
        return $workers;
    }

    public function get_the_nearest_worker($availableWorkers, $latitude, $longitude)
    {
        // compare locations of available workers to location of user then return this worker.
        // use distance matrix.


        Log::error("tessssssssssssssssssssssssssssstes");
        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=';
        $key = 'AIzaSyAPaKpXjMyHW7g55YVj--jtOvrwLIVrUUs';
        // $destinations = '31.264807,30.010371';
        $destinations = $latitude . ',' . $longitude;
        $nearestWorker;

        for ($i=0; $i < count($availableWorkers); $i++) { 
            // $heading = '31.272793,30.006345';
            $heading = $availableWorkers[$i]['latitude'] . ',' . $availableWorkers[$i]['longitude'];
            $response = Http::get($url . 'heading=90:' . $heading . '&destinations=' . $destinations . '&key=' . $key);

            // get the nearest worker by less duration.
            if ($response['rows'][0]['elements'][0]) {
                if ($i == 0) {
                    $nearestWorker = $availableWorkers[$i];
                    $nearestWorker['durationValue'] = $response['rows'][0]['elements'][0]['duration']['value'];
                    $nearestWorker['distanceValue'] = $response['rows'][0]['elements'][0]['distance']['value'];
                } else {
                    if ($nearestWorker['durationValue'] > $response['rows'][0]['elements'][0]['duration']['value']) {
                        $nearestWorker = $availableWorkers[$i];
                        $nearestWorker['durationValue'] = $response['rows'][0]['elements'][0]['duration']['value'];
                        $nearestWorker['distanceValue'] = $response['rows'][0]['elements'][0]['distance']['value'];
                    }
                }
                $availableWorkers[$i]['distance'] = $response['rows'][0]['elements'][0]['distance']['text'];
                $availableWorkers[$i]['duration'] = $response['rows'][0]['elements'][0]['duration']['text'];
            }
        }

        // add duration and distance to worker's table.
        $worker_DB = Worker::find($nearestWorker['id']);
        $worker_DB->duration_in_seconds = $nearestWorker['durationValue'];
        $worker_DB->distance_in_meters = $nearestWorker['distanceValue'];
        $worker_DB->save();      

        // return this worker.
        return $worker_DB;
    }

    public function create_order($userId, $workerId)
    {
        // create order in order's table.
        $data;
        $data['user_id'] = $userId;
        $data['worker_id'] = $workerId;
        $row = Order::create($data);
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
