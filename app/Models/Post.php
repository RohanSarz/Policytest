<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'image', 'slug', 'category_id'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = $post->generateUniqueSlug($post->title);
            } elseif ($post->isDirty('title')) {
                // If the title changes, regenerate the slug
                $post->slug = $post->generateUniqueSlug($post->title);
            }
        });
    }

    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // For updates, exclude the current post from the check
        $query = self::where('slug', $slug);
        if ($this->id) {
            $query->where('id', '!=', $this->id);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;

            // Check again with the new slug
            $query = self::where('slug', $slug);
            if ($this->id) {
                $query->where('id', '!=', $this->id);
            }
        }

        return $slug;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
