<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])->get();
        $users = User::all();

        return Inertia::render('Admin/Posts', [
            'posts' => $posts,
            'users' => $users,
        ]);
    }

    public function updateStatus(Request $request, Post $post)
    {
        $request->validate([
            'status' => 'required|in:published,pending,archived,deleted',
        ]);

        $post->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Post status updated successfully.');
    }
}