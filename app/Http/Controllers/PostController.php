<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['auth', new Middleware('can:create,App\Models\Post', only: ['create', 'store']), new Middleware('can:update,post', only: ['edit', 'update']), new Middleware('can:delete,post', only: ['destroy'])];
    }

    public function index(Category $category = null)
    {
        $query = Post::query()->with(['user', 'category']);

        if ($category) {
            $query->where('category_id', $category->id);
        }

        $posts = $query->latest()->get();

        $categories = Category::all(['id', 'name']);

        return inertia('Home', compact('posts', 'categories'));
    }
    public function create()
    {
        $categories = Category::all(['id', 'name']);
        return inertia('Posts/Create', compact('categories'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
        }
        //dd($imagePath);
        Post::create([
            'title' => $fields['title'],
            'body' => $fields['body'],
            'category_id' => $fields['category_id'] ?? null,
            'user_id' => $request->user()->id,
            'image' => $imagePath ?? null,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category']);
        $post->created_for_human = Carbon::parse($post->created_at)->diffForHumans();
        // dd($post);
        // Pass the post along with its relationships to the Inertia view
        return inertia('Posts/Show', [
            'post' => $post,
        ]);
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
