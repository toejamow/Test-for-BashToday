<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
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
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => fake()->sentence(),
            'excerpt' => fake()->paragraph(1),
            'content' => fake()->paragraphs(2, true),
            'image' => 'https://picsum.photos/seed/' . fake()->word() . '/800/600', 
        ];
    }
}
