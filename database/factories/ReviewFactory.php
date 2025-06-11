<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
            'user_id' => Customer::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
        ];
    }
}
