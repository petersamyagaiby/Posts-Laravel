<?php

namespace Database\Seeders;

use App\Models\Creator;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // if (Creator::count() == 0) {
        //     Creator::factory(10)->create();
        // }

        if (User::count() == 0) {
            User::factory(10)->create();
        }

        if (Post::count() == 0) {
            Post::factory(500)->create();
        }
    }
}
