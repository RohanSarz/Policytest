<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [new Middleware('auth', except: ['index', 'show'])];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Home', [
            'posts' => Post::with(['user', 'category'])
                ->latest()
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(['id', 'name']);

        return inertia('Post/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $field = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        $imagePath = $field['image'] ?? 'post-images/newsDef.jpg';

        // Handle file upload if an image file is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
        }

        Post::create([
            'user_id' => Auth::user()->id,
            'category_id' => $field['category_id'],
            'title' => $field['title'],
            'body' => $field['body'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->intended('dashboard')
            ->with([
                'message' => 'Post created successfully!',
                'type' => 'success',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // if (!Gate::allows('view', Post::findOrfail($id))) {
        //     return back()->with([
        //         'message' => 'You are not allowed to view this post!',
        //         'type' => 'warning',
        //     ]);
        // }

        $post = Post::with(['user', 'category'])->findOrFail($id);

        return inertia('Post/Show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Gate::allows('view', Post::findOrfail($id))) {
            return redirect()
                ->back()
                ->with([
                    'message' => 'Not Your Post!',
                    'type' => 'warning',
                ]);
        }

        return inertia('Post/Edit', [
            'post' => Post::with('category')->findOrFail($id),
            'categories' => \App\Models\Category::all(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (!Gate::allows('update', $post)) {
            return redirect()
                ->back()
                ->with([
                    'message' => 'Not Your Post!',
                    'type' => 'warning',
                ]);
        }

        $fields = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        $imagePath = $post->image; // Keep existing image if no new one is provided

        // Handle file upload if an image file is provided
        if ($request->hasFile('image')) {
            // Delete old image if it's not the default
            if ($post->image && $post->image !== 'post-images/newsDef.jpg') {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('post-images', 'public');
        } elseif (isset($fields['image'])) {
            $imagePath = $fields['image'];
        }

        $post->update([
            'title' => $fields['title'],
            'body' => $fields['body'],
            'category_id' => $fields['category_id'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('posts.show', $post->id)
            ->with([
                'message' => 'Post updated successfully!',
                'type' => 'success',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('delete', Post::findOrfail($id))) {
            return redirect()
                ->back()
                ->with([
                    'message' => 'Not Your Post!',
                    'type' => 'warning',
                ]);
        }

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
