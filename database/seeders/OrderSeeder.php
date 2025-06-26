<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $consumers = User::where('role', 'consumer')->get();
        $restaurants = Restaurant::all();
        if ($consumers->count() < 2 || $restaurants->count() < 2) return;
        Order::create([
            'user_id' => $consumers[0]->id,
            'restaurant_id' => $restaurants[0]->id,
            'total_price' => 21.98,
            'status' => 'completed',
            'payment_status' => 'paid',
            'delivery_address' => '789 Elm St',
            'placed_at' => Carbon::now()->subDays(2),
            'completed_at' => Carbon::now()->subDays(2)->addHour(),
        ]);
        Order::create([
            'user_id' => $consumers[1]->id,
            'restaurant_id' => $restaurants[1]->id,
            'total_price' => 16.98,
            'status' => 'completed',
            'payment_status' => 'paid',
            'delivery_address' => '321 Oak St',
            'placed_at' => Carbon::now()->subDay(),
            'completed_at' => Carbon::now()->subDay()->addHour(),
        ]);
    }
}
