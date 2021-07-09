<?php

namespace App\Http\Controllers;
use App\Http\Requests\LocationRequest as LocationRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Worker;
use App\Models\Order;
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
        $user->latitude = $data['latitude'];
        $user->longitude = $data['longitude'];
        $user->save();

        // return 10 available locations of workers. search in table and check on status of worker.
        $availableWorkers = $this->get_available_workers($data['latitude'], $data['longitude']);

        // return the nearest worker
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
        // query to retrieve nearest 10 workers to the user

        $workers = Worker::select('id', 'latitude','longitude',
            DB::raw('3956 * 2 * ASIN(SQRT( POWER(SIN(ABS('.$latitude.' - latitude) * pi()/180 / 2), 2) + COS('.$longitude.' * pi()/180 ) * COS(latitude * pi()/180) * POWER(SIN(ABS('.$longitude.' - longitude) * pi()/180 / 2), 2) ))AS distance'))
            ->where('status', 1)
            ->orderBy('distance')
            ->limit(10)
            ->get();

        Log::error($workers);
        return $workers;
    }

    public function get_the_nearest_worker($availableWorkers, $latitude, $longitude)
    {
       $url ='https://maps.googleapis.com/maps/api/distancematrix/json?';

       // create the query that will be used in the request
       $query['origins'] = '';
       foreach( $availableWorkers as $availableWorker) {
            $query['origins'] .= $availableWorker->latitude;
            $query['origins'] .= ',';
            $query['origins'] .= $availableWorker->longitude;
            $query['origins'] .= '|';
       }
       if($query['origins'][-1] === '|')
           $query['origins'] = substr($query['origins'], 0, -1);


       $query['destinations'] = $latitude . ',' . $longitude;
       $query['key'] = 'AIzaSyAPaKpXjMyHW7g55YVj--jtOvrwLIVrUUs';

       // create the request
        $response = Http::get($url, $query);

        // get duration and distance for each worker
        $finalAvailableWorkers = [];
        for($index = 0; $index < count($response['rows']); $index++){
           $row =  $response['rows'][$index];
            foreach ($row['elements'] as $element) {
              switch ($element['status']){
                  case 'OK':
                      $avWorker = $availableWorkers[$index];
                      $avWorker['duration_in_seconds'] = $element['duration']['value'];
                      $avWorker['distance_in_meters'] = $element['distance']['value'];
                      $avWorker->save();
                      array_push($finalAvailableWorkers, $avWorker);
                      break;

              }
           }
        }

        // sort available workers by duration
        usort($finalAvailableWorkers, function ($obj1, $obj2){
            return strcmp($obj1->duration_in_seconds, $obj2->duration_in_seconds);

        });


        // return the nearest worker after sort the array of workers
        return $finalAvailableWorkers[0];
    }

    public function create_order($userId, $workerId)
    {
        // create order in order's table.
        $data['user_id'] = $userId;
        $data['worker_id'] = $workerId;
        Order::create($data);
    }

    // Worker Part
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
