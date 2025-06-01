<?php

namespace Database\Factories;

use App\Models\OrderDetail; // Đảm bảo bạn đã tạo OrderDetail Model
use App\Models\Order;       // Import Order Model
use App\Models\Product;     // Import Product Model
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetail::class; // Hoặc App\Models\OrderDetail::class

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $order = Order::inRandomOrder()->first();

        if (!$order) {
            $order = Order::factory()->create();
        }

        $product = Product::inRandomOrder()->first();

        if (!$product) {
            $product = Product::factory()->create();
        }

        return [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 10),
            'created_at' => $order->created_at,
            'updated_at' => $order->created_at,
        ];
    }

}
