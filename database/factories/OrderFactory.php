<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Order_date'=>$this->faker->dateTime,
            'Weight'=>$this->faker->numberBetween(1,1000),
            'Point_earned'=>$this->faker->numberBetween(50,10000),
        ];
    }
}
