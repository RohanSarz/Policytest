<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'roAdmin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin@mail.com'),
            'remember_token' => Str::random(10),
        ])->assignRole('admin');
    }
}
