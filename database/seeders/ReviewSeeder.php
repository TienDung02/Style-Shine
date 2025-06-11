<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Customer;
use App\Models\OrderDetail;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $users = Customer::all();

        foreach ($users as $user) {
            $productIds = OrderDetail::whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->pluck('product_id')->unique();

            foreach ($productIds as $productId) {
                if (rand(0, 1)) {
                    Review::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'rating' => rand(3, 5),
                        'comment' => fake()->sentence(),
                    ]);
                }
            }
        }
    }
}
