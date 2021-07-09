<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // password
            'age'=>$this->faker->numberBetween(1,60),
            'vehicle_type'=>$this->faker->mimeType,
            'salary'=>$this->faker->numberBetween(1000,50000),
            'role'=> $this->faker->numberBetween(1,6),
            'government'=>$this->faker->country,
//            'latitude' => $this->faker->numberBetween(0,180),
//            'longitude' => $this->faker->numberBetween(0,360),
        ];
    }
}
