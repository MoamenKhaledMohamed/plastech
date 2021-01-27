<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyOrder;
use Illuminate\Database\Seeder;

class CompanyOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            // one to many relation with company

            CompanyOrder::factory()
                ->times(10)
                ->for(Company::factory())
                ->create();
        }
    }
}
