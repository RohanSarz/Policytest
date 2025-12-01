<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['name', 'user_id', 'post_id'];

    public function scopeWithNames()
    {
        return $this->whereNotNull('name');
    }
}
