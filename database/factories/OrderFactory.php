<?php

namespace Database\Factories;

use App\Models\Order; // Đảm bảo bạn đã tạo Order Model
use App\Models\User;  // Đảm bảo bạn có User Model (Laravel mặc định có)
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = ['paid', 'unpaid', 'shipping', 'preparing', 'delivered', 'cancelled'];
        $paymentMethods = ['Cash', 'Credit Card', 'Bank Transfer', 'MoMo', 'ZaloPay'];

        $userId = User::inRandomOrder()
            ->where('role', '!=', 1)
            ->first()?->id ?? User::factory()->create()->id;


        return [
            'total_price' => $this->faker->randomFloat(2, 10, 5000),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'status' => $this->faker->randomElement($statuses),
            'user_id' => $userId,
            'created_at' => $createdAt = $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => null,
            'payment_date' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }

}
