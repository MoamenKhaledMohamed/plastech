<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // one to many relation with User
        // one to many relation with Worker
        Order::factory()
            ->times(10)
            ->for(User::factory())
            ->for(Worker::factory())
            ->create();
    }
}
