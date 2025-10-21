<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Ro',
            'email' => 'r@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('r@mail.com'),
        ]);
        Post::factory(10)->create();
    }
}
