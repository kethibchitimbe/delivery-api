<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Consumers
        User::create([
            'name' => 'Alice Consumer',
            'email' => 'alice.consumer@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'role' => 'consumer',
        ]);
        User::create([
            'name' => 'Bob Consumer',
            'email' => 'bob.consumer@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567891',
            'role' => 'consumer',
        ]);
        // Restaurant Owners
        User::create([
            'name' => 'Carol Owner',
            'email' => 'carol.owner@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567892',
            'role' => 'restaurant',
        ]);
        User::create([
            'name' => 'Dave Owner',
            'email' => 'dave.owner@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567893',
            'role' => 'restaurant',
        ]);
        // Delivery Partners
        User::create([
            'name' => 'Eve Delivery',
            'email' => 'eve.delivery@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567894',
            'role' => 'delivery',
        ]);
        User::create([
            'name' => 'Frank Delivery',
            'email' => 'frank.delivery@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567895',
            'role' => 'delivery',
        ]);
        // Admin
        User::create([
            'name' => 'Grace Admin',
            'email' => 'grace.admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567896',
            'role' => 'admin',
        ]);
    }
}
