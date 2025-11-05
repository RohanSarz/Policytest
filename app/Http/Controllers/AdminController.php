<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        // Get total post count
        $totalPosts = Post::count();
        
        // Get verified user count (users with email verified)
        $totalVerifiedUsers = User::whereNotNull('email_verified_at')->count();
        
        // Get total user count
        $totalUsers = User::count();

        return Inertia::render('Admin/Dashboard', [
            'totalPosts' => $totalPosts,
            'totalVerifiedUsers' => $totalVerifiedUsers,
            'totalUsers' => $totalUsers,
        ]);
    }
}
