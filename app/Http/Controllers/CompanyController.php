<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function get_my_daily_target($id)
    {
        /*
         * take worker's id
         * return myTime, myWeight and myNumberOfOrders as json
         * note : myTime, myWeight and myNumberOfOrders are called the target of worker.
         */
    }

   public function set_remaining_daily_target_by_admin($id)
   {
       /*
        * the purpose of this method is "updating the remaining daily target for the worker after each order"
        * 1- take worker's id
        * 2- call get_my_daily_target($id) to get the target of worker
        * 3- call calculate_remaining_daily_target_by_admin(id, time, weight, numberOfOrders) to change on the remaining daily target for the worker
        * 4- return the new remaining target as json
        * Note : this method we call on it in WorkerController inside set_weight()
        * Note : totalTime, numberOfOrders and weight are put by admin.
        */
   }

   public function calculate_remaining_daily_target_by_admin($id, $time, $weight, $numberOfOrders): array
   {
      /*
       * you should take the target of worker
       * admin sets the new remaining daily target of worker depending on the target of worker.
       * example: if a worker doesn't work then
       *    the initial values are 8 hours for time, 8 times for orders and one kilo for weight.
       * create your equation to calculate the new  remaining target depends on the target of worker.
       * Notes :
       * 1- time should be at least 6 hours to 8 hours
       * 2- orders should be at least 6 times to 8 times
       * 3- weight should be at least 700 g to one kilo
       * 4- first priority for time then weight then number_of_orders
       * 5- your equation must be at range
       * after that you should update the new values of remaining target (total_time, number_of_orders, weight)
       * call update_daily_target_by_admin(id, time, weight, numberOfOrders)
       * return array contains new time, weight and numberOfOrders.
       */
       return [];
   }

   public function update_remaining_daily_target_by_admin($id, $time, $weight, $numberOfOrders)
   {
        //you should update the new values of remaining target(total_time, number_of_orders, weight)
   }
}
