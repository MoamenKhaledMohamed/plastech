<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class CompanyController extends Controller
{
    public function get_my_weekly_target($id)
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

   public function set_remaining_weekly_target_by_admin($id,$weight)
   {
       //find id of worker
       $worker=Worker::find($id);
       //get current date
       $currentDate = Carbon::now();
       //add 7 days to current date
       $newDate = Carbon::now()->addDays(7);
       //get endDate from database
       $endDate = $worker->end_at;
       //get current user weight from database
       $currentWeight = $worker->my_weight;
       //check if week has passed or not by comparing between current date and end date
       if($currentDate>$endDate){
           //check if worker has completed target within week or not
           //then save the salary in data base with new with
           if($currentWeight > 40){
               $worker->salary = 2500 + (($currentWeight - 40) * 0);
               $worker->my_weight=$weight;
               $worker->save();
           }
           elseif ($currentWeight == 40){
               $worker->salary = 2500;
               $worker->my_weight = $weight;
               $worker->save();
           }
           else{
               $worker->salary = $currentWeight*50;
               $worker->my_weight = $weight;
               $worker->save();
           }
           $worker->start_at = $currentDate;
           $worker->end_at = $newDate;
           $worker->save();
       }

       elseif($currentDate <= $endDate){
        //if we still in current week then add new weight to the old weight
           $worker->my_weight += $weight;
           $worker->save();
       }
      //note:i put the new weight of the new order as parameter with id
      // it can be changed to be a passed as a request or deleted as u want
   }

    //if u have a comment on these to functions pls write it and if u dont please delete them


   public function calculate_remaining_weekly_target_by_admin($id, $weight, $endAt): array
   {

       return [];
   }

   public function update_remaining_weekly_target_by_admin($id)
   {

   }
}
