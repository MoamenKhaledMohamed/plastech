<?php

namespace Database\Factories;

use App\Models\Problem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Problem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [

        'description'=>$this->faker->sentence,
       'screenshot'=>$this->faker->sentence,
        ];
    }
}
