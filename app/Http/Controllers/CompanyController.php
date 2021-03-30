<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class CompanyController extends Controller
{
    public function get_my_weekly_target($id): JsonResponse
    {
        //find worker by id
        $worker = Worker::find($id);
        //return data as json
        return response()->json([
            'weight' => $worker->my_weight,
            'startDate' => $worker->start_at,
            'endDate' => $worker->end_at,
        ], 200);

    }

   public function get_salary($id): JsonResponse
   {

       $worker = Worker::find($id);
       $currentDate = Carbon::now();
       $endDate = $worker->end_at;
       //check if week has passed or not by comparing between current date and end date
       if($currentDate > $endDate){
            //get current user weight from database
           $currentWeight = $worker->my_weight;
            //calculate bounce weight
           $myBounce = (($currentWeight - 40) * 20);
           //check if worker has completed target within week or not
           //then save the salary in data base
           $worker->salary = ($currentWeight >= 40) ? 2500 + $myBounce : $currentWeight * 50;
           //reset worker target (weight,startDate,endDate) in database
           $worker->my_weight = 0;
           $worker->start_at = $currentDate;
           $worker->end_at = Carbon::now()->addDays(7);
           $worker->save();


       }

       return response()->json([
           'startDate' => $worker->start_at,
           'endDate' => $worker->end_at,
           'salary' =>  $worker->salary,
       ], 200);
   }

}
