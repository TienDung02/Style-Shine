<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $imageCount = 1;

        foreach ($products as $product) {
            ProductImage::factory()->create([
                'product_id' => $product->id,
                'image_url' => "/storage/uploads/product/images/img_{$imageCount}.png",
            ]);
            $imageCount++;

            if ($imageCount <= 30 && rand(0, 1)) {
                ProductImage::factory()->create([
                    'product_id' => $product->id,
                    'image_url' => "/storage/uploads/product/images/img_{$imageCount}.png",
                ]);
                $imageCount++;
            }

            if ($imageCount > 30) break;
        }
    }
}
