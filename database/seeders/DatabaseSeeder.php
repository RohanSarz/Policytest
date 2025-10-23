<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Post::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        // Create a user
        $user = User::create([
            'name' => 'Ro',
            'email' => 'r@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('r@mail.com'),
        ]);

        $categories = ['Technology', 'Sports', 'Politics', 'Lifestyle', 'Travel'];
        foreach ($categories as $category) {
            // Create each permission if it doesn't already exist
            Category::create(['name' => $category]);
        }
    }
}
