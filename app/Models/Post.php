<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use HTMLPurifier;
use HTMLPurifier_Config;

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

    /**
     * Accessor: Get sanitized HTML content
     */
    public function getSafeContentAttribute(): string
    {
        $config = HTMLPurifier_Config::createDefault();
        
        // Allow common HTML tags but remove dangerous ones
        $config->set('HTML.Allowed', 'p,br,strong,em,u,ol,ul,li,a[href],img[src|alt|width|height],h1,h2,h3,h4,h5,h6,blockquote,code,pre');
        $config->set('HTML.AllowedAttributes', 'href,src,alt,width,height');
        $config->set('AutoFormat.RemoveEmpty', true);
        
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($this->content);
    }
}
