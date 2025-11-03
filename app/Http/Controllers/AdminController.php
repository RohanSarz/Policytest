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
}
