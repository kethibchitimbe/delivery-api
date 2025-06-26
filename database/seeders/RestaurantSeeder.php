<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\User;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owners = User::where('role', 'restaurant')->get();
        if ($owners->count() < 2) return;
        Restaurant::create([
            'user_id' => $owners[0]->id,
            'name' => 'Pizza Palace',
            'address' => '123 Main St',
            'phone' => '555-1111',
            'description' => 'Best pizza in town!',
            'logo_url' => 'https://placehold.co/100x100/pizza.png',
            'is_active' => true,
        ]);
        Restaurant::create([
            'user_id' => $owners[1]->id,
            'name' => 'Sushi Central',
            'address' => '456 Ocean Ave',
            'phone' => '555-2222',
            'description' => 'Fresh sushi and rolls.',
            'logo_url' => 'https://placehold.co/100x100/sushi.png',
            'is_active' => true,
        ]);
    }
}
