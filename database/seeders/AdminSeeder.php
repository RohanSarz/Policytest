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
        $admin = User::create([
            'name' => 'roAdmin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin@mail.com'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $admin->syncRoles('admin');
    }
}
