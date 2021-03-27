<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function get_my_weekly_target($id)
    {
        /*
         * take worker's id
         * return  myWeight, startAt and endAt as json
         */
    }

   public function set_remaining_weekly_target_by_admin($id)
   {
       /*
        * the purpose of this method is "updating the remaining daily target for the worker after each order"
        * 1- take worker's id
        * 2- call get_my_daily_target($id) to get the target of worker
        * 3- call calculate_remaining_daily_target_by_admin(id, weight, endAt) to change on the remaining daily target for the worker
        * 4- return the new remaining target as json
        * Note : this method we call on it in WorkerController inside set_weight()
        */
   }

   public function calculate_remaining_weekly_target_by_admin($id, $weight, $endAt): array
   {

       return [];
   }

   public function update_remaining_weekly_target_by_admin($id, $weight)
   {
        //you should update the new values of remaining target(weight)
   }
}
