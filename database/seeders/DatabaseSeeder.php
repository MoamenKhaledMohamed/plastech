<?php

namespace Database\Seeders;
use App\Models\CompanyOrder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  \App\Models\User::factory(10)->create();
        $this->call([
            // run all seeders when run comand (db:seed)
            AdminSeeder::class,
            CompanySeeder::class,
             CompanyOrderSeeder::class,
            OrderSeeder::class,
            ProblemSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            WorkerSeeder::class
        ]);
    }
}
