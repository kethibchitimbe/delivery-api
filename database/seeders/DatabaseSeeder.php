<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RestaurantSeeder::class,
            MenuSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            DeliverySeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
