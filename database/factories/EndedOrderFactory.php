<?php

namespace Database\Factories;

use App\Models\EndedOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class EndedOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EndedOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'order_date'=>$this->faker->dateTime,
            'weight'=>$this->faker->numberBetween(1,1000),
            'point_earned'=>$this->faker->numberBetween(50,10000),
        ];
    }
}
