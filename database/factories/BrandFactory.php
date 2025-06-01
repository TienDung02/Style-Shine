<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class BrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'desc' => $this->faker->paragraph(),
            'logo' => $this->faker->imageUrl(200, 200, 'business', true, 'Brand'),
        ];
    }
}
