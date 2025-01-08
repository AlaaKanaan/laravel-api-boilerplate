<?php

namespace Database\Seeders;

use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'authority' => [UserTypes::ADMIN],
        ]);

        User::query()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'authority' => [UserTypes::USER],
        ]);
    }
}
