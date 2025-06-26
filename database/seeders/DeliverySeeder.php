<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::all();
        $partners = User::where('role', 'delivery')->get();
        if ($orders->count() < 2 || $partners->count() < 2) return;
        Delivery::create([
            'order_id' => $orders[0]->id,
            'delivery_partner_id' => $partners[0]->id,
            'status' => 'delivered',
            'delivered_at' => Carbon::now()->subDays(2)->addHours(2),
        ]);
        Delivery::create([
            'order_id' => $orders[1]->id,
            'delivery_partner_id' => $partners[1]->id,
            'status' => 'delivered',
            'delivered_at' => Carbon::now()->subDay()->addHours(2),
        ]);
    }
}
