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
    public function definition()
    {
        return [
            'Firstname' => $this->faker->firstName,
            'Lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'Age'=>$this->faker->numberBetween(1,60),
            'Vehicle_type'=>$this->faker->mimeType,
            'Salary'=>$this->faker->numberBetween(1000,50000),
            'Role'=> $this->faker->numberBetween(1,6),
            'Government'=>$this->faker->country,
        ];
    }
}
