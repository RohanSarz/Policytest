<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Home', [
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $field = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $field['title'],
            'body' => $field['body'],
        ]);

        return redirect()
            ->intended('dashboard')
            ->with([
                'message' => 'Project created successfully!',
                'type' => 'success',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user')->findOrFail($id);

        return inertia('Post/Show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = $request->validate(
            rules: [
                'avatar' => ['file', 'image', 'max:3000', 'nullable'],
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed'],
            ],
        );

        $fields['password'] = bcrypt($fields['password']);

        $fields['avatar'] = $request->hasFile('avatar') ? Storage::disk('public')->put('avatars', $request->avatar) : Storage::disk('public')->put('avatars', 'def.jpg');
        // register

        $user = User::create($fields);

        // login

        Auth::login($user);

        // redirect
        return redirect()
            ->route('dashboard')
            ->with([
                'message' => 'Project Updated successfully!',
                'type' => 'success',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()
            ->route('dashboard')
            ->with([
                'message' => 'Project Deleted!',
                'type' => 'success',
            ]);
    }
}
