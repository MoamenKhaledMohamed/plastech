<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Worker::factory()
            ->times(10)
            ->create();
    }
}
