<?php

namespace Database\Factories;

use App\Models\Category;
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
            'user_id' => 1,
            'category_id' => Category::latest()->inRandomOrder()->id(),
            'image' => fake()->imageUrl(),
            'title' => $title,
            'slug' => $slug,
            'body' => fake()->paragraph(),
        ];
    }
}
