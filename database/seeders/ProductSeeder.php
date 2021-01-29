<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // one to many relation with User
        Product::factory()
            ->count(5)
            ->has(User::factory())
            ->create();
    }
}
