<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Customer;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = Customer::all();
        $products = Product::all();

        foreach ($users as $user) {
            $orders = Order::factory(rand(1, 3))->create([
                'user_id' => $user->id,
            ]);

            foreach ($orders as $order) {
                $orderTotal = 0;

                $selectedProducts = $products->random(rand(1, 5));

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $subtotal = $product->price * $quantity;
                    $orderTotal += $subtotal;

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                    ]);
                }

                $order->update(['total_price' => $orderTotal]);
            }
        }
    }
}
