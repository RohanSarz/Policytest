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
        $title = fake()->sentence();

        $slug = Str::slug($title);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()?->id,
            'cover' => 'https://placehold.co/600x400',
            'image' => 'https://placehold.co/600x400',
            'title' => $title,
            'excerpt' => fake()->sentence(),
            'slug' => $slug,
            'content' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(['pending', 'published', 'draft']),
        ];
    }
}
