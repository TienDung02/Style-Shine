<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Customer;
use Faker\Factory as Faker;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        Customer::create([
            'username' => 'admin',
            'password' => 123456,
            'full_name' => 'Administrator',
            'email' => 'nongtiendung2309@gmail.com',
            'phone' => '0123456789',
            'address' => '123 Admin Street',
            'gender' => 'male',
            'avatar' => '/storage/uploads/user/avatar/avatar_1.jpg',
            'role' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);

        Customer::factory()->count(50)->create()->each(function ($user, $index) {
            $user->update([
                'role' => 0,
                'avatar' => "/storage/uploads/user/avatar/avatar_" . ($index + 1) . ".jpg",
            ]);
        });
    }
}
