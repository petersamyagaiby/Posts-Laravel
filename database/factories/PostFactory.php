<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $creatorIds = User::pluck("id")->toArray();
        return [
            "title" => fake()->unique()->sentence(3),
            "description" => fake()->sentence(20),
            "image" => null,
            "user_id" => fake()->randomElement($creatorIds),
        ];
    }
}
