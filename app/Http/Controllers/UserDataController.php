<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDataController extends Controller
{
    public function profileView()
    {
        $user = Auth::user();
        $posts = Post::with(['user', 'category'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $trendingPosts = Post::with(['user', 'category'])
            ->where('status', 'approved')
            ->latest()
            ->limit(5)
            ->get();

        return inertia('User/Profile', [
            'user' => $user,
            'posts' => $posts,
            'trendingPosts' => $trendingPosts,
        ]);
    }

    public function dashboardView()
    {
        $posts = Post::with(['user', 'category'])
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();

        // user is passed globally in HandleInertiaRequests.php
        return inertia('User/Dashboard', [
            'posts' => $posts,
            'categories' => Category::all(['id', 'name', 'slug']),
        ]);
    }

    // Method post update profile data
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email'],
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()
            ->route('profile')
            ->with([
                'type' => 'success',
                'message' => 'Profile updated successfully!',
            ]);
    }

    public function updateAvatar(Request $request)
    {
        // 1. Validate that a file was uploaded and it's an image
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // 2. Get the current user
        $user = Auth::user();

        // 3. Store the file in /storage/app/public/avatars
        //    put() returns the relative path (e.g., "avatars/xyz.jpg")
        $path = $request->file('avatar')->store('avatars', 'public');

        // 4. Save the path to the user's avatar field
        $user->avatar = $path;
        $user->save();

        // 5. Return success response (Inertia-friendly)
        return redirect()
            ->back()
            ->with([
                'type' => 'success',
                'message' => 'Avatar updated successfully!',
            ]);
    }
}
