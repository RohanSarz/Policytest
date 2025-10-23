<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth', new Middleware('can:create,App\Models\Post', only: ['create', 'store']), new Middleware('can:update,post', only: ['edit', 'update']), new Middleware('can:delete,post', only: ['destroy'])];
    }

    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->latest()
            ->get();
        return inertia('Home', compact('posts'));
    }

    public function create()
    {
        return inertia('Posts/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category_id' => $validated['category_id'] ?? null,
            'user_id' => $request->user()->id,
            'image' => $request->file('image')?->store('posts'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created!');
    }

    public function show(Post $post)
    {
        // Eager load the 'user' and 'category' relationships
        $post->load(['user', 'category']);

        // Pass the post along with its relationships to the Inertia view
        return inertia('Posts/Show', compact('post'));
    }

    public function edit(Post $post)
    {
        return inertia('Posts/Edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category_id' => $validated['category_id'] ?? null,
            'image' => $request->file('image')?->store('posts') ?? $post->image,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted!');
    }
}
