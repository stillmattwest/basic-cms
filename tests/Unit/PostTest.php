<?php

use App\Models\Post;

// Test basic model configuration
test('post has all fillable attributes', function () {
    $fillable = [
        'title', 'slug', 'content', 'excerpt', 
        'meta_title', 'meta_description', 
        'featured_image', 'featured_image_alt',
        'status', 'published_at', 'is_featured', 'user_id'
    ];
    
    $post = new Post();
    
    expect($post->getFillable())->toBe($fillable);
});

test('post has correct casts', function () {
    $post = new Post();
    $casts = $post->getCasts();
    
    expect($casts['published_at'])->toBe('datetime');
    expect($casts['is_featured'])->toBe('boolean');
});

test('is_published accessor works correctly', function () {
    $publishedPost = new Post(['status' => 'published']);
    $draftPost = new Post(['status' => 'draft']);
    
    expect($publishedPost->is_published)->toBeTrue();
    expect($draftPost->is_published)->toBeFalse();
});

test('uses id as route key', function () {
    $post = new Post();
    
    // After our security changes, we use ID for admin routes
    expect($post->getRouteKeyName())->toBe('id');
});