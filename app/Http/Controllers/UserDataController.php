<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserDataController extends Controller
{
    public function profileView()
    {
        // user is passed globally in HandleInertiaRequests.php
        return inertia('User/Profile');
    }
    public function dashboardView()
    {
        $posts = Post::with('user')
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();
        // user is passed globally in HandleInertiaRequests.php
        return inertia('User/Dashboard', [
            'posts' => $posts,
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
}
