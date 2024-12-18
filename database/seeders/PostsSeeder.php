<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming the users exist (IDs 1, 2, and 3)
        Post::factory(10)->create(['user_id' => 1]); // Posts for Admin User
        Post::factory(5)->create(['user_id' => 2]); // Posts for Moderator User
        Post::factory(15)->create(['user_id' => 3]); // Posts for Regular User
    }
}
