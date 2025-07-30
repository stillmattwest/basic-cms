<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        // basic content
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
        // relationships
        'user_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Relationship: Post belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Get only published posts
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: Get only featured posts
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Get posts ordered by publication date
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Accessor: Check if post is published
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Accessor: Get the published date or created date if not published
     */
    public function getDisplayDateAttribute()
    {
        return $this->published_at ?? $this->created_at;
    }

    /**
     * Accessor: Get formatted display date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->display_date->format('M j, Y');
    }

    /**
     * Accessor: Get the public URL for this post
     */
    public function getUrlAttribute(): string
    {
        return route('posts.public.show', $this->slug);
    }
}
