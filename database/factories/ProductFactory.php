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
    public function definition(): array
    {
        return [
            'name'=>$this->faker->safeColorName,
            'price'=>$this->faker->numberBetween(100,10000),
           'description'=>$this->faker->sentence,
           'counter'=>$this->faker->numberBetween(1,100),
           'image'=>$this->faker->imageUrl($width = 640, $height = 480) ,
        ];
    }
}
