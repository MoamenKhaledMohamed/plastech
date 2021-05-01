<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    // User Part
    public function get_order(float $latitude, float $longitude): \Illuminate\Http\JsonResponse
    {
        // validation.

        // return available locations of workers. search in table and check on status of worker.
        $availableWorkers = $this->get_available_workers($latitude, $longitude);

        // return the nearest worker.
        $worker = $this->get_the_nearest_worker($availableWorkers);

        // insert in order's table then return all info(worker's place, time) between this worker and this user.
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

    // Worker Part

    public function change_my_status(float $latitude, float $longitude, bool $status)
    {
       // validation
        // insert to data base a new status and his location.
        // create another api to check the order's table by date of changing with date of order and is_End and his id
    }
}
