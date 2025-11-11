<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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

    public function permissions()
    {
        $permissions = Permission::all();

        return Inertia::render('Admin/Permissions', [
            'permissions' => $permissions,
        ]);
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    // Roles Management
    public function roles()
    {
        // Get all roles with their permissions
        $roles = Role::with('permissions')->get();

        // Get all available permissions to show in the form
        $permissions = Permission::all();

        return Inertia::render('Admin/Roles', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully.');
    }

    // Users Management
    public function users()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return Inertia::render('Admin/Users', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function storeUser(Request $request)
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
            $user->syncRoles($request->role);
        }

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    // Posts Management
    public function posts()
    {
        $posts = Post::with(['user', 'category'])->get();
        $users = User::all();

        return Inertia::render('Admin/Posts', [
            'posts' => $posts,
            'users' => $users,
        ]);
    }

    public function updatePostStatus(Request $request, $postId)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,archived',
        ]);
        
        $post = Post::findOrFail($postId);
        $post->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Post status updated successfully.');
    }
}
