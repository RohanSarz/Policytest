<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
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

    // Index page
    public function index()
    {
        $query = Post::query()->with(['user', 'category', 'postImages']);

        $allPosts = $query->where('status', 'approved')->latest()->get();
        $livePosts = $query->where('status', 'approved')->latest()->paginate(5);
        $featCategoryPosts = $query->where('category_id', operator: 'politics')->latest()->paginate(5);

        return inertia('Home', [
            'allPosts' => $allPosts,
            'livePosts' => $livePosts,
            'featCategoryPosts' => $featCategoryPosts,
        ]);
    }
    // Index page but with category

    public function byCategory(string $slug): Response|ResponseFactory
    {
        // Load the category or fail if not found
        $category = Category::where('slug', $slug)->firstOrFail();

        // Get posts that belong to this category with 'approved' status
        $posts = Post::with(['user', 'category', 'postImages'])
            ->where('category_id', $category->id)
            ->where('status', 'approved')
            ->latest()
            ->get();

        // Get all categories for sidebar or filters
        $categories = Category::all(['id', 'name', 'slug']);

        return inertia('Home', [
            'posts' => $posts,
            'categories' => $categories,
            'currentCategory' => $category,
        ]);
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
            'content' => 'required|string', // This will be JSON string
            'cover_image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg', // Changed to match model
            'post_images' => 'nullable|array', // Multiple images
            'post_images.*' => 'image|max:2048|mimes:png,jpg,jpeg', // Each image validation
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $coverPath = null;

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('post-covers', 'public');
        }

        // Decode the JSON content before storing
        $content = $fields['content'];
        if (is_string($content) && !empty($content)) {
            $decodedContent = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $content = $content; // Keep as JSON string
            } else {
                // If not valid JSON, treat as HTML
                $content = $fields['content'];
            }
        }

        $post = Post::create([
            'title' => $fields['title'],
            'excerpt' => $fields['excerpt'],
            'content' => $content,
            'cover_image' => $coverPath ?? null,
            'category_id' => $fields['category_id'] ?? null,
            'user_id' => $request->user()->id,
        ]);

        // Handle multiple images upload
        if ($request->hasFile('post_images')) {
            foreach ($request->file('post_images') as $index => $image) {
                $path = $image->store('post-images', 'public');
                PostImage::create([
                    'post_id' => $post->id,
                    'url' => $path,
                    'order' => $index, // Maintain order
                    'alt_text' => null, // Can be added later
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post created!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'category', 'postImages']); // Load multiple images
        $post->created_for_human = Carbon::parse($post->created_at)->diffForHumans();

        // Transform the post to properly handle content format
        $postData = $post->toArray();

        // If content is JSON, we might need special handling for display
        // For now, sending as is, but in practice you'd convert JSON to HTML for display

        // Pass the post along with its relationships to the Inertia view
        return inertia('Posts/Show', [
            'post' => $post,
        ]);
    }

    public function edit(Post $post)
    {
        $post->load('postImages'); // Load existing images for editing
        $categories = Category::all(['id', 'name']);

        // Transform the post data to ensure content is properly formatted
        $postData = $post->toArray();

        // If the content is JSON and we need to handle it differently for the editor
        // For now, we'll send it as is, but make sure it's properly processed

        return inertia('Posts/Edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048|mimes:png,jpg,jpeg', // Changed to match model
            'post_images' => 'nullable|array', // Multiple images
            'post_images.*' => 'image|max:2048|mimes:png,jpg,jpeg', // Each image validation
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Handle cover image upload
        $coverPath = $post->cover_image; // Keep existing path if no new file
        if ($request->hasFile('cover_image')) {
            // Delete old cover if exists
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('post-covers', 'public');
        }

        // Decode the JSON content before storing
        $content = $validated['content'];
        if (is_string($content) && !empty($content)) {
            $decodedContent = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $content = $content; // Keep as JSON string
            } else {
                // If not valid JSON, treat as HTML
                $content = $validated['content'];
            }
        }

        $post->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'content' => $content,
            'cover_image' => $coverPath,
            'category_id' => $validated['category_id'] ?? null,
        ]);

        // Handle multiple images upload
        if ($request->hasFile('post_images')) {
            foreach ($request->file('post_images') as $index => $image) {
                $path = $image->store('post-images', 'public');
                PostImage::create([
                    'post_id' => $post->id,
                    'url' => $path,
                    'order' => $index, // Maintain order
                    'alt_text' => null, // Can be added later
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        // Delete all related images first
        foreach ($post->postImages as $image) {
            if (Storage::disk('public')->exists($image->url)) {
                Storage::disk('public')->delete($image->url);
            }
            $image->delete();
        }

        // Delete cover image if exists
        if ($post->cover_image && Storage::disk('public')->exists($post->cover_image)) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted!');
    }
}
