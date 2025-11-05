<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display the specified user's profile and posts.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $posts = Post::with('user')->where('user_id', $user->id)->latest()->get();

        return inertia('User/Show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    /**
     * Admin method to display all users
     */
    public function adminIndex()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return Inertia::render('Admin/Users', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    /**
     * Admin method to store a new user
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->role) {
            $user->assignRole($request->role);
        }

        return redirect()->back()->with('success', 'User created successfully.');
    }

    /**
     * Admin method to delete a user
     */
    public function adminDestroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
