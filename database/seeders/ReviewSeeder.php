<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::all();
        $users = User::where('role', 'consumer')->get();
        $restaurants = Restaurant::all();
        if ($orders->count() < 2 || $users->count() < 2 || $restaurants->count() < 2) return;
        Review::create([
            'order_id' => $orders[0]->id,
            'user_id' => $users[0]->id,
            'restaurant_id' => $restaurants[0]->id,
            'rating' => 5,
            'comment' => 'Delicious pizza and fast delivery!'
        ]);
        Review::create([
            'order_id' => $orders[1]->id,
            'user_id' => $users[1]->id,
            'restaurant_id' => $restaurants[1]->id,
            'rating' => 4,
            'comment' => 'Great sushi, will order again.'
        ]);
    }
}
