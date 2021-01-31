<?php

namespace Database\Factories;

use App\Models\CompanyOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'price'=>$this->faker->numberBetween(500,10000),
            'weight'=>$this->faker->numberBetween(1,1000),
            'arrival_date'=>$this->faker->dateTime,
        ];
    }
}
