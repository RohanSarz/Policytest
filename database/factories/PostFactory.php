<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = fake()->realText(50); // More human-readable title

        $slug = Str::slug($title);
        $status = fake()->randomElement(['pending', 'approved', 'draft']);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()?->id,
            'cover_image' => 'https://placehold.co/600', // Fixed field name
            'title' => $title,
            'excerpt' => fake()->realText(200), // More human-like excerpt
            'slug' => $slug,
            'content' => fake()->realText(1000), // More human-readable content
            'status' => $status,
        ];
    }
}
