<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/AdminIndex', [
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }

    public function getRoles()
    {
        // Get all users with their roles
        $users = User::with('roles', 'roles.permissions')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'status' => $user->email_verified_at ? 'active' : 'inactive',
                    'role' => $user->roles->first() ? $user->roles->first()->name : 'No Role',
                    'permissions' => $user->roles->first() ? $user->roles->first()->permissions->pluck('name')->toArray() : [],
                ];
            });

        return Inertia::render('Admin/Roles/AdminRoles', [
            'users' => $users,
        ]);
    }
    public function settingsView()
    {
        return Inertia::render('Admin/AdminIndex', [
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }
}
