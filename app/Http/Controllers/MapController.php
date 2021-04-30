<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    //
    public function get_order(int $latitude, int $longitude): \Illuminate\Http\JsonResponse
    {
        // validation.

        // return available locations of workers.
        $availableWorkers = $this->get_available_workers($latitude, $longitude);

        // return the nearest worker.
        $worker = $this->get_the_nearest_worker($availableWorkers);

        // return all info(worker's place, time) between this worker and this user.
        $info_of_route = $this->get_info_of_route();

        // return all info and worker's data to user as json.
        return response()->json([]);
    }

    public function get_available_workers(int $latitude,int $longitude): array
    {
        // return array of workers by equation.
        return [];
    }

    public function get_the_nearest_worker($availableWorkers)
    {
        // compare locations of available workers to location of user then return this worker.
    }

    public function get_info_of_route()
    {
        // by using api from google map.
    }
}
