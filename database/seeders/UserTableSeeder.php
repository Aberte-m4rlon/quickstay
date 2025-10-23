<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the user seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
    ['email' => 'admin@example.com'],
    ['name' => 'Admin User', 'password' => bcrypt('secret'), 'role' => 'admin', 'is_verified' => true]
);

User::updateOrCreate(
    ['email' => 'owner@example.com'],
    ['name' => 'Owner User', 'password' => bcrypt('secret'), 'role' => 'owner', 'is_verified' => true]
);

User::updateOrCreate(
    ['email' => 'renter@example.com'],
    ['name' => 'Renter User', 'password' => bcrypt('secret'), 'role' => 'renter', 'is_verified' => true]
);
    }
}
