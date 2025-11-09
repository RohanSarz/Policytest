<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'cover_image', 'title', 'excerpt', 'slug', 'content', 'status'];

    // Use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at?->diffForHumans();
    }
    public function getUpdatedAtHumanAttribute()
    {
        return $this->updated_at?->diffForHumans();
    }

    protected static function boot()
    {
        parent::boot();

        // Only set initial status and slug when creating
        static::creating(function ($post) {
            $post->status = 'pending';
            if (empty($post->slug)) {
                $post->slug = $post->generateUniqueSlug($post->title);
            }
        });

        // Regenerate slug if title changes on update
        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = $post->generateUniqueSlug($post->title);
            }
        });
    }

    // Ensure slug uniqueness
    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->when($this->id, fn($q) => $q->where('id', '!=', $this->id))->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship for multiple images - ordered by the 'order' column
    public function postImages(): HasMany
    {
        return $this->hasMany(PostImage::class, 'post_id')->orderBy('order');
    }
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    public function scopeCategory($query)
    {
        return $query->where('category_id', $this->category_id);
    }

    // Accessor to get content as HTML, converting from JSON if needed
    public function getContentAsHtmlAttribute()
    {
        $content = $this->content;

        // Check if content is in JSON format
        if (is_string($content) && !empty($content)) {
            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                // If it's valid JSON, we would need to convert it back to HTML
                // For now, return as is; in a full implementation you'd convert JSON to HTML
                return $content;
            }
        }

        return $content;
    }
}
