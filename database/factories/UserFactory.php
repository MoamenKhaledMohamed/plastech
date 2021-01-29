<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstNameFemale,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'date_of_birth'=>$this->faker->dateTime,
           'government'=>$this->faker->country,
            'card_id'=>$this->faker->creditCardNumber,
            'number_of_points'=>$this->faker->numberBetween(1000,50000),
            'name_on_card'=> $this->faker->firstName,
            'card_expiration_date'=>$this->faker->creditCardExpirationDate,
        ];
    }
}
