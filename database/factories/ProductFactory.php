<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name_product' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quality' => $this->faker->randomElement(['New', 'Used', 'Refurbished']),
            'description' => $this->faker->paragraph(),
            'id_category' => \App\Models\Category::factory(),
        ];
    }
}
