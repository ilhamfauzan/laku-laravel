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
            [
                'name' => 'Thom Baker',
                'email' => 'thom@laundry.com',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ],
            [
                'name' => 'Maggie Cheung',
                'email' => 'maggie@laundry.com',
                'password' => Hash::make('password'),
                'role' => 'cashier',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@laundry.com',
                'password' => Hash::make('password'),
                'role' => 'unauthorized',
            ],
        ]);

        // Seed services data
        DB::table('services')->insert([
            [
                'service_name' => 'Standard',
                'service_price' => 8000.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Express',
                'service_price' => 10000.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Instant',
                'service_price' => 15000.00,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed laundry data
        DB::table('laundries')->insert([
            [
                'customer_name' => 'Tony Leung',
                'customer_phone_number' => '089755538123',
                'laundry_weight' => 10.00,
                'laundry_date' => now(),
                'user_id' => 1,
                'service_id' => 1,
                'status' => 'Unfinished',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_name' => 'Faye Wong',
                'customer_phone_number' => '081266662122',
                'laundry_weight' => 5.00,
                'laundry_date' => now(),
                'user_id' => 1,
                'service_id' => 2,
                'status' => 'Unfinished',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_name' => 'Brigitte Lin',
                'customer_phone_number' => '083267772899',
                'laundry_weight' => 5.00,
                'laundry_date' => now(),
                'user_id' => 1,
                'service_id' => 2,
                'status' => 'Finished',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed transaction data
        DB::table('transactions')->insert([
            [
                'payment_date' => now(),
                'total_price' => 50000.00,
                'payment_status' => 'completed',
                'user_id' => 1,
                'laundry_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
