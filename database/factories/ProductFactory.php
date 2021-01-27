<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Name'=>$this->faker->safeColorName,
            'Price'=>$this->faker->numberBetween(100,10000),
           'Description'=>$this->faker->sentence,
           'counter'=>$this->faker->numberBetween(1,100),
           'Image'=>$this->faker->userAgent,
        ];
    }
}
