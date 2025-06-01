<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
class OrderDetailedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = Product::all()->pluck('id_product');
        $orderIds = Order::all()->pluck('id');
        foreach($orderIds as $orderId) {
            $detailsCount = rand(1, 5);
            OrderDetail::factory()->count($detailsCount)->create([
                'order_id' => $orderId,
                'product_id' => function (array $attributes) use ($productIds) {
                    return $productIds->random();
                },
                'quantity' => rand(1, 10),
            ]);
        }
    }
}
