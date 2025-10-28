<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        return redirect()->back()->with([
            'type' => 'success',
            'message' => 'Avatar updated successfully!'
        ]);
    }
}
