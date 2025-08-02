<?php

use App\Models\Post;
use App\Models\User;

// Test relationships
test('post belongs to user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    expect($post->user)->toBeInstanceOf(User::class);
    expect($post->user->id)->toBe($user->id);
});

test('published scope filters only published posts', function () {
    Post::factory()->published()->create();
    Post::factory()->draft()->create();
    Post::factory()->archived()->create();
    
    $publishedPosts = Post::published()->get();
    
    expect($publishedPosts)->toHaveCount(1);
    expect($publishedPosts->first()->status)->toBe('published');
});

test('featured scope filters only featured posts', function () {
    Post::factory()->featured()->create();
    Post::factory()->create(['is_featured' => false]);
    Post::factory()->create(['is_featured' => false]);
    
    $featuredPosts = Post::featured()->get();
    
    expect($featuredPosts)->toHaveCount(1);
    expect($featuredPosts->first()->is_featured)->toBeTrue();
});

test('latest scope orders by published_at desc', function () {
    $oldPost = Post::factory()->published()->create([
        'published_at' => now()->subDays(3)
    ]);
    $newPost = Post::factory()->published()->create([
        'published_at' => now()->subDay()
    ]);
    $newestPost = Post::factory()->published()->create([
        'published_at' => now()
    ]);
    
    $posts = Post::latest()->get();
    
    expect($posts->first()->id)->toBe($newestPost->id);
    expect($posts->last()->id)->toBe($oldPost->id);
});

// Test accessors
test('is_published accessor works correctly', function () {
    $publishedPost = Post::factory()->published()->create();
    $draftPost = Post::factory()->draft()->create();
    $archivedPost = Post::factory()->archived()->create();
    
    expect($publishedPost->is_published)->toBeTrue();
    expect($draftPost->is_published)->toBeFalse();
    expect($archivedPost->is_published)->toBeFalse();
});

test('display_date accessor formats correctly', function () {
    $post = Post::factory()->published()->create([
        'published_at' => '2024-01-15 10:30:00'
    ]);
    
    expect($post->display_date)->toBe('January 15, 2024');
});

test('formatted_date accessor formats correctly', function () {
    $post = Post::factory()->published()->create([
        'published_at' => '2024-01-15 10:30:00'
    ]);
    
    expect($post->formatted_date)->toBe('Jan 15, 2024');
});

test('url accessor generates correct route', function () {
    $post = Post::factory()->create(['slug' => 'test-post-slug']);
    
    expect($post->url)->toBe(route('posts.public.show', $post->slug));
});

// Test route key binding
test('uses slug as route key', function () {
    $post = new Post();
    
    expect($post->getRouteKeyName())->toBe('slug');
});

test('route key value returns slug', function () {
    $post = Post::factory()->create(['slug' => 'test-slug']);
    
    expect($post->getRouteKey())->toBe('test-slug');
});

// Test factory states
test('factory creates valid posts with different states', function () {
    $publishedPost = Post::factory()->published()->create();
    $draftPost = Post::factory()->draft()->create();
    $featuredPost = Post::factory()->featured()->create();
    $archivedPost = Post::factory()->archived()->create();
    
    expect($publishedPost->status)->toBe('published');
    expect($publishedPost->published_at)->not->toBeNull();
    
    expect($draftPost->status)->toBe('draft');
    expect($draftPost->published_at)->toBeNull();
    
    expect($featuredPost->is_featured)->toBeTrue();
    
    expect($archivedPost->status)->toBe('archived');
});

test('factory with SEO state creates SEO fields', function () {
    $post = Post::factory()->withSeo()->create();
    
    expect($post->meta_title)->not->toBeNull();
    expect($post->meta_description)->not->toBeNull();
});

test('factory creates unique slugs', function () {
    $post1 = Post::factory()->create();
    $post2 = Post::factory()->create();
    
    expect($post1->slug)->not->toBe($post2->slug);
});

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

test('published_at is cast to datetime', function () {
    $post = Post::factory()->published()->create();
    
    expect($post->published_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

test('is_featured is cast to boolean', function () {
    $post = Post::factory()->create(['is_featured' => 1]);
    
    expect($post->is_featured)->toBeTrue();
    expect($post->is_featured)->toBeBool();
});