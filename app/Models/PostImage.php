<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    protected $fillable = ['post_id', 'url', 'order', 'alt_text'];

    // Relationship to the post
    public function post(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Post::class);
    }
}
