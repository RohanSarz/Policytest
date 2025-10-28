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
            'excerpt' => 'required|string|max:255',
            'content' => 'required|string',
            'cover' => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
            'image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $coverPath = null;
        $imagePath = null;
        
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('post-covers', 'public');
        }
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
        }

        Post::create([
            'title' => $fields['title'],
            'excerpt' => $fields['excerpt'],
            'content' => $fields['content'],
            'cover' => $coverPath ?? null,
            'image' => $imagePath ?? null,
            'category_id' => $fields['category_id'] ?? null,
            'user_id' => $request->user()->id,
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
            'excerpt' => 'required|string|max:255',
            'content' => 'required|string',
            'cover' => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
            'image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Handle cover image upload
        $coverPath = $post->cover; // Keep existing path if no new file
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($post->cover) {
                Storage::disk('public')->delete($post->cover);
            }
            $coverPath = $request->file('cover')->store('post-covers', 'public');
        }

        // Handle image upload
        $imagePath = $post->image; // Keep existing path if no new file
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('post-images', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'content' => $validated['content'],
            'cover' => $coverPath,
            'image' => $imagePath,
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted!');
    }
}
