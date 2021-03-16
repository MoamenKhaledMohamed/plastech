<?php

namespace Database\Seeders;

use App\Models\Problem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
        // one to many relation with Product
        // one to many relation with Problem
    {
        User::factory()
            ->has(Product::factory())
            ->has(Problem::factory())
            ->create();
    }
}
