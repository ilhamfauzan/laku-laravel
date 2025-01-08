<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed login data
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        // Seed services data
        DB::table('services')->insert([
            [
                'service_name' => 'Standar',
                'service_price' => 100.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Express',
                'service_price' => 200.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Instant',
                'service_price' => 150.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed laundry data
        DB::table('laundries')->insert([
            [
                'customer_name' => 'John Doe',
                'customer_phone_number' => '123456789',
                'laundry_weight' => 5.00,
                'laundry_date' => now(),
                'user_id' => 1,
                'service_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_name' => 'Jane Doe',
                'customer_phone_number' => '987654321',
                'laundry_weight' => 3.00,
                'laundry_date' => now(),
                'user_id' => 1,
                'service_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed transaction data
        DB::table('transactions')->insert([
            [
                'payment_date' => now(),
                'total_price' => 150.00,
                'payment_status' => 'completed',
                'user_id' => 1,
                'laundry_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'payment_date' => now(),
                'total_price' => 300.00,
                'payment_status' => 'pending',
                'user_id' => 1,
                'laundry_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
