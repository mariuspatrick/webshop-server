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
            'title' => $this->faker->word,
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 1000),
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween($min = 1, $max = 100)
        ];
    }
}
