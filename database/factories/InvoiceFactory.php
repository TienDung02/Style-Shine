<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-2 years', 'now');
        return [
            'total_price' => $this->faker->randomFloat(2, 1, 100),
            'payment_method' => $this->faker->randomElement(['Cash', 'Credit Card', 'Transfer']),
            'customer_id' => Customer::factory(),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
