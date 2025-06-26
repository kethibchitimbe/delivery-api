<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Restaurant;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurants = Restaurant::all();
        if ($restaurants->count() < 2) return;
        // Pizza Palace
        Menu::create([
            'restaurant_id' => $restaurants[0]->id,
            'name' => 'Margherita Pizza',
            'description' => 'Classic cheese and tomato pizza.',
            'price' => 9.99,
            'image_url' => 'https://placehold.co/100x100/margherita.png',
            'is_available' => true,
        ]);
        Menu::create([
            'restaurant_id' => $restaurants[0]->id,
            'name' => 'Pepperoni Pizza',
            'description' => 'Pepperoni and cheese.',
            'price' => 11.99,
            'image_url' => 'https://placehold.co/100x100/pepperoni.png',
            'is_available' => true,
        ]);
        // Sushi Central
        Menu::create([
            'restaurant_id' => $restaurants[1]->id,
            'name' => 'Salmon Roll',
            'description' => 'Fresh salmon with rice and seaweed.',
            'price' => 7.99,
            'image_url' => 'https://placehold.co/100x100/salmonroll.png',
            'is_available' => true,
        ]);
        Menu::create([
            'restaurant_id' => $restaurants[1]->id,
            'name' => 'Tuna Nigiri',
            'description' => 'Slices of tuna over rice.',
            'price' => 8.99,
            'image_url' => 'https://placehold.co/100x100/tunanigiri.png',
            'is_available' => true,
        ]);
    }
}
