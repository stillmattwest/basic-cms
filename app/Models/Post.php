<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected $fillable = [
        // basic content
        'id',
        'title',
        'slug',
        'content',
        'excerpt',
        // metadata
        'meta_title',
        'meta_description',
        'featured_image',
        'featured_image_alt',
        // status and visibility
        'status',
        'published_at',
        'is_featured',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
