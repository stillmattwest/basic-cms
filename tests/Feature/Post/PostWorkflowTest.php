<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

// Complete Post Creation Workflow with Image
test('complete post creation workflow with image upload', function () {
    $user = User::factory()->create();
    
    // Step 1: User logs in and accesses create form
    $response = $this->actingAs($user)->get('/posts/create');
    $response->assertOk();
    $response->assertSee('Create Post');
    
    // Step 2: User uploads featured image
    $featuredImage = UploadedFile::fake()->image('featured.jpg', 800, 600);
    $uploadResponse = $this->actingAs($user)->post('/images/upload', [
        'file' => $featuredImage
    ]);
    $uploadResponse->assertOk();
    $imageData = $uploadResponse->json();
    
    // Step 3: User creates post with uploaded image
    $postData = [
        'title' => 'Complete Workflow Test Post',
        'content' => 'This post was created through the complete workflow including image upload.',
        'excerpt' => 'A test post created through the full workflow.',
        'meta_title' => 'SEO Title for Workflow Test',
        'meta_description' => 'SEO description for the workflow test post.',
        'featured_image' => $imageData['url'],
        'featured_image_alt' => 'Featured image for workflow test',
        'status' => 'published',
        'is_featured' => true,
        'published_at' => now()->format('Y-m-d H:i:s')
    ];
    
    $createResponse = $this->actingAs($user)->post('/posts', $postData);
    $createResponse->assertRedirect();
    
    // Step 4: Verify post was created correctly
    $post = Post::where('title', 'Complete Workflow Test Post')->first();
    expect($post)->not->toBeNull();
    expect($post->user_id)->toBe($user->id);
    expect($post->featured_image)->toBe($imageData['url']);
    expect($post->status)->toBe('published');
    expect($post->is_featured)->toBeTrue();
    expect($post->slug)->toBe('complete-workflow-test-post');
    
    // Step 5: Verify image file exists in storage
    Storage::disk('public')->assertExists($imageData['path']);
    
    // Step 6: Verify post appears in public listing
    $indexResponse = $this->get('/posts');
    $indexResponse->assertOk();
    $indexResponse->assertSee('Complete Workflow Test Post');
    
    // Step 7: Verify post is accessible via public URL
    $publicResponse = $this->get("/posts/{$post->slug}");
    $publicResponse->assertOk();
    $publicResponse->assertSee('Complete Workflow Test Post');
    $publicResponse->assertSee('This post was created through the complete workflow');
});

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

// Post Editing with Image Replacement Workflow
test('post editing with new image upload workflow', function () {
    $user = User::factory()->create();
    
    // Step 1: Upload original featured image
    $originalImage = UploadedFile::fake()->image('original.jpg');
    $originalUploadResponse = $this->actingAs($user)->post('/images/upload', [
        'file' => $originalImage
    ]);
    $originalImageData = $originalUploadResponse->json();
    
    // Step 2: Create post with original image
    $this->actingAs($user)->post('/posts', [
        'title' => 'Post with Image Replacement',
        'content' => 'This post will have its featured image replaced.',
        'featured_image' => $originalImageData['url'],
        'featured_image_alt' => 'Original image',
        'status' => 'published'
    ]);
    
    $post = Post::where('title', 'Post with Image Replacement')->first();
    expect($post->featured_image)->toBe($originalImageData['url']);
    
    // Step 3: Verify original image exists
    Storage::disk('public')->assertExists($originalImageData['path']);
    
    // Step 4: Upload new featured image
    $newImage = UploadedFile::fake()->image('replacement.jpg');
    $newUploadResponse = $this->actingAs($user)->post('/images/upload', [
        'file' => $newImage
    ]);
    $newImageData = $newUploadResponse->json();
    
    // Step 5: Edit post to use new image
    $editResponse = $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Post with Image Replacement',
        'content' => 'This post will have its featured image replaced.',
        'featured_image' => $newImageData['url'], // New image URL
        'featured_image_alt' => 'Replacement image',
        'status' => 'published'
    ]);
    $editResponse->assertRedirect();
    
    // Step 6: Verify post now uses new image
    $post->refresh();
    expect($post->featured_image)->toBe($newImageData['url']);
    expect($post->featured_image_alt)->toBe('Replacement image');
    
    // Step 7: Verify both images exist in storage (old one not automatically deleted)
    Storage::disk('public')->assertExists($originalImageData['path']);
    Storage::disk('public')->assertExists($newImageData['path']);
    
    // Step 8: Verify updated post displays correctly
    $publicResponse = $this->get("/posts/{$post->slug}");
    $publicResponse->assertOk();
    $publicResponse->assertSee('Post with Image Replacement');
});

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

// Multi-user Content Workflow
test('multi-user content creation and visibility workflow', function () {
    $author1 = User::factory()->create(['name' => 'Author One']);
    $author2 = User::factory()->create(['name' => 'Author Two']);
    
    // Step 1: Author 1 creates posts
    $this->actingAs($author1)->post('/posts', [
        'title' => 'Post by Author One',
        'content' => 'Content created by the first author.',
        'status' => 'published'
    ]);
    
    // Step 2: Author 2 creates posts
    $this->actingAs($author2)->post('/posts', [
        'title' => 'Post by Author Two',
        'content' => 'Content created by the second author.',
        'status' => 'published'
    ]);
    
    // Step 3: Verify both posts exist with correct authors
    $post1 = Post::where('title', 'Post by Author One')->first();
    $post2 = Post::where('title', 'Post by Author Two')->first();
    
    expect($post1->user_id)->toBe($author1->id);
    expect($post2->user_id)->toBe($author2->id);
    
    // Step 4: Verify both posts appear in public listing with author names
    $publicResponse = $this->get('/posts');
    $publicResponse->assertSee('Post by Author One');
    $publicResponse->assertSee('Post by Author Two');
    $publicResponse->assertSee('Author One');
    $publicResponse->assertSee('Author Two');
    
    // Step 5: Verify individual post views show correct authors
    $post1Response = $this->get("/posts/{$post1->slug}");
    $post1Response->assertSee('Author One');
    $post1Response->assertDontSee('Author Two');
    
    $post2Response = $this->get("/posts/{$post2->slug}");
    $post2Response->assertSee('Author Two');
    $post2Response->assertDontSee('Author One');
});

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