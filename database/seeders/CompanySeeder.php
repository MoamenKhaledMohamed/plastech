<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyOrder;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // one to many relation with company order
        Company::factory()
            ->count(5)
            ->has(CompanyOrder::factory())
            ->create();
    }
}
