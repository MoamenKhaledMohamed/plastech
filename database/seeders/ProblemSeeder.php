<?php

namespace Database\Seeders;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // one to many relation with User
        Problem::factory()
            ->times(10)
            ->for(User::factory())
            ->create();
    }
}
