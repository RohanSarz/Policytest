<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the specified user's profile and posts.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $posts = Post::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return inertia('User/Show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}