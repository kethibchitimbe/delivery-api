<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Menu;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::all();
        $menus = Menu::all();
        if ($orders->count() < 2 || $menus->count() < 4) return;
        // Order 1: 2 Margherita, 1 Pepperoni
        OrderItem::create([
            'order_id' => $orders[0]->id,
            'menu_id' => $menus[0]->id,
            'quantity' => 2,
            'price' => 9.99,
        ]);
        OrderItem::create([
            'order_id' => $orders[0]->id,
            'menu_id' => $menus[1]->id,
            'quantity' => 1,
            'price' => 11.99,
        ]);
        // Order 2: 1 Salmon Roll, 2 Tuna Nigiri
        OrderItem::create([
            'order_id' => $orders[1]->id,
            'menu_id' => $menus[2]->id,
            'quantity' => 1,
            'price' => 7.99,
        ]);
        OrderItem::create([
            'order_id' => $orders[1]->id,
            'menu_id' => $menus[3]->id,
            'quantity' => 2,
            'price' => 8.99,
        ]);
    }
}
