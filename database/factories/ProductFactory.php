<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->word(),
            'description' => $this->faker->unique()->realText($maxNbChars = 200, $indexSize = 2),
            'cost' => $this->faker->randomFloat( 2, 1, 5000),
            'slug' => Product::generateUniqueCode(),
        ];
    }
}
