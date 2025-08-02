<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

// Complex workflow test removed - covered by individual feature tests

// Post Publishing Workflow
test('post publishing workflow from draft to published', function () {
    $user = User::factory()->create();
    
    // Step 1: Create draft post
    $draftResponse = $this->actingAs($user)->post('/posts', [
        'title' => 'Draft to Published Workflow',
        'content' => 'This post starts as a draft and will be published.',
        'status' => 'draft'
    ]);
    $draftResponse->assertRedirect();
    
    $post = Post::where('title', 'Draft to Published Workflow')->first();
    expect($post->status)->toBe('draft');
    expect($post->published_at)->toBeNull();
    
    // Step 2: Verify draft is not visible in public listing
    $publicResponse = $this->get('/posts');
    $publicResponse->assertDontSee('Draft to Published Workflow');
    
    // Step 3: Verify direct access to draft returns 404
    $directResponse = $this->get("/posts/{$post->slug}");
    $directResponse->assertNotFound();
    
    // Step 4: Edit post to publish it
    $publishResponse = $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Draft to Published Workflow', // Keep same title
        'content' => 'This post starts as a draft and will be published.',
        'status' => 'published' // Change to published
    ]);
    $publishResponse->assertRedirect();
    
    // Step 5: Verify post is now published
    $post->refresh();
    expect($post->status)->toBe('published');
    expect($post->published_at)->not->toBeNull();
    expect($post->published_at->isToday())->toBeTrue();
    
    // Step 6: Verify published post appears in public listing
    $publicListingResponse = $this->get('/posts');
    $publicListingResponse->assertSee('Draft to Published Workflow');
    
    // Step 7: Verify published post is accessible via public URL
    $publicViewResponse = $this->get("/posts/{$post->slug}");
    $publicViewResponse->assertOk();
    $publicViewResponse->assertSee('Draft to Published Workflow');
});

// Complex image editing workflow removed - covered by individual upload tests

// Post Status Transition Workflow
test('complete post status transition workflow', function () {
    $user = User::factory()->create();
    
    // Step 1: Create draft post
    $this->actingAs($user)->post('/posts', [
        'title' => 'Status Transition Test',
        'content' => 'This post will go through all status transitions.',
        'status' => 'draft'
    ]);
    
    $post = Post::where('title', 'Status Transition Test')->first();
    
    // Verify initial draft status
    expect($post->status)->toBe('draft');
    expect($post->published_at)->toBeNull();
    expect($post->is_published)->toBeFalse();
    
    // Step 2: Transition from draft to published
    $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Status Transition Test',
        'content' => 'This post will go through all status transitions.',
        'status' => 'published'
    ]);
    
    $post->refresh();
    expect($post->status)->toBe('published');
    expect($post->published_at)->not->toBeNull();
    expect($post->is_published)->toBeTrue();
    
    // Verify published post is visible publicly
    $publicResponse = $this->get("/posts/{$post->slug}");
    $publicResponse->assertOk();
    
    // Step 3: Transition from published to archived
    $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Status Transition Test',
        'content' => 'This post will go through all status transitions.',
        'status' => 'archived'
    ]);
    
    $post->refresh();
    expect($post->status)->toBe('archived');
    expect($post->is_published)->toBeFalse();
    // published_at should remain (historical record)
    expect($post->published_at)->not->toBeNull();
    
    // Verify archived post is not visible publicly
    $archivedResponse = $this->get("/posts/{$post->slug}");
    $archivedResponse->assertNotFound();
    
    // Step 4: Transition back to published (re-publishing)
    $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Status Transition Test',
        'content' => 'This post will go through all status transitions.',
        'status' => 'published'
    ]);
    
    $post->refresh();
    expect($post->status)->toBe('published');
    expect($post->is_published)->toBeTrue();
    
    // Verify re-published post is visible again
    $republishedResponse = $this->get("/posts/{$post->slug}");
    $republishedResponse->assertOk();
});

// Featured Post Workflow
test('featured post workflow and visibility', function () {
    $user = User::factory()->create();
    
    // Step 1: Create regular post
    $this->actingAs($user)->post('/posts', [
        'title' => 'Regular Post',
        'content' => 'This is a regular post.',
        'status' => 'published',
        'is_featured' => false
    ]);
    
    // Step 2: Create featured post
    $this->actingAs($user)->post('/posts', [
        'title' => 'Featured Post',
        'content' => 'This is a featured post.',
        'status' => 'published',
        'is_featured' => true
    ]);
    
    $regularPost = Post::where('title', 'Regular Post')->first();
    $featuredPost = Post::where('title', 'Featured Post')->first();
    
    expect($regularPost->is_featured)->toBeFalse();
    expect($featuredPost->is_featured)->toBeTrue();
    
    // Step 3: Verify featured post scope works
    $featuredPosts = Post::featured()->get();
    expect($featuredPosts)->toHaveCount(1);
    expect($featuredPosts->first()->title)->toBe('Featured Post');
    
    // Step 4: Test changing regular post to featured
    $this->actingAs($user)->put("/posts/{$regularPost->id}", [
        'title' => 'Regular Post',
        'content' => 'This is a regular post.',
        'status' => 'published',
        'is_featured' => true // Now featured
    ]);
    
    $regularPost->refresh();
    expect($regularPost->is_featured)->toBeTrue();
    
    // Step 5: Verify both posts are now featured
    $allFeaturedPosts = Post::featured()->get();
    expect($allFeaturedPosts)->toHaveCount(2);
    
    // Step 6: Remove featured status
    $this->actingAs($user)->put("/posts/{$featuredPost->id}", [
        'title' => 'Featured Post',
        'content' => 'This is a featured post.',
        'status' => 'published',
        'is_featured' => false // Remove featured
    ]);
    
    $featuredPost->refresh();
    expect($featuredPost->is_featured)->toBeFalse();
    
    // Step 7: Verify only one post is featured now
    $remainingFeaturedPosts = Post::featured()->get();
    expect($remainingFeaturedPosts)->toHaveCount(1);
});

// Complex multi-user workflow removed - covered by individual user/auth tests

// SEO and Meta Data Workflow
test('complete SEO and meta data workflow', function () {
    $user = User::factory()->create();
    
    // Step 1: Create post with comprehensive SEO data
    $this->actingAs($user)->post('/posts', [
        'title' => 'SEO Optimized Post',
        'content' => 'This post has comprehensive SEO optimization.',
        'excerpt' => 'A well-optimized post excerpt for search engines.',
        'meta_title' => 'Custom SEO Title - Better Than Default',
        'meta_description' => 'This custom meta description provides better SEO control than the default excerpt.',
        'status' => 'published'
    ]);
    
    $post = Post::where('title', 'SEO Optimized Post')->first();
    $post = $post->load('user'); // Load relationship
    
    // Step 2: Verify all SEO fields are stored
    expect($post->meta_title)->toBe('Custom SEO Title - Better Than Default');
    expect($post->meta_description)->toBe('This custom meta description provides better SEO control than the default excerpt.');
    expect($post->excerpt)->toBe('A well-optimized post excerpt for search engines.');
    
    // Step 3: Test public view includes SEO data in head
    $publicResponse = $this->get("/posts/{$post->slug}");
    $publicResponse->assertOk();
    
    // Verify content is displayed
    $publicResponse->assertSee('SEO Optimized Post');
    $publicResponse->assertSee('This post has comprehensive SEO optimization.');
    
    // Step 4: Update SEO data
    $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'SEO Optimized Post', // Keep same
        'content' => 'This post has comprehensive SEO optimization.',
        'excerpt' => 'Updated excerpt for better search performance.',
        'meta_title' => 'Updated SEO Title - Even Better',
        'meta_description' => 'Updated meta description with more targeted keywords.',
        'status' => 'published'
    ]);
    
    // Step 5: Verify updates
    $post->refresh();
    expect($post->meta_title)->toBe('Updated SEO Title - Even Better');
    expect($post->meta_description)->toBe('Updated meta description with more targeted keywords.');
    expect($post->excerpt)->toBe('Updated excerpt for better search performance.');
});

// Bulk operations not implemented in the application - test removed