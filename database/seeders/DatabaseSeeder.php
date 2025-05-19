<?php

namespace Database\Seeders;

// database/seeders/DatabaseSeeder.php

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::factory()->create([
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);

        Customer::factory()->count(50)->create();
        Category::factory()->count(10)->create();
        $categoryIds = Category::all()->pluck('id');
        Product::factory()->count(100)->create([
            'id_category' => function (array $attributes) use ($categoryIds) {
                return $categoryIds->random();
            },
        ]);
        $customerUsernames = Customer::all()->pluck('id');
        Invoice::factory()->count(200)->create([
            'customer_id' => function (array $attributes) use ($customerUsernames) {
                return $customerUsernames->random();
            },
        ]);
        Review::factory()->count(300)->create([
            'customer_id' => function (array $attributes) use ($customerUsernames) {
                return $customerUsernames->random();
            },
        ]);
        $invoiceIds = Invoice::all()->pluck('id');
        $productIds = Product::all()->pluck('id_product');

        foreach($invoiceIds as $invoiceId) {
            $detailsCount = rand(1, 5);
            InvoiceDetail::factory()->count($detailsCount)->create([
                'id_invoice' => $invoiceId, // Gán chi tiết này cho invoice cụ thể
                'id_product' => function (array $attributes) use ($productIds) {
                    return $productIds->random();
                },
                'quality' => rand(1, 10),
            ]);
        }
    }
}
