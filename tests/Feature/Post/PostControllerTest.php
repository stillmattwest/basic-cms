<?php

use App\Models\Post;
use App\Models\User;

// Public Routes Tests
test('guests can view posts index', function () {
    $publishedPost = Post::factory()->published()->create();
    $draftPost = Post::factory()->draft()->create();
    
    $response = $this->get('/posts');
    
    $response->assertOk();
    $response->assertSee($publishedPost->title);
    $response->assertDontSee($draftPost->title);
});

test('posts index shows only published posts', function () {
    Post::factory()->published()->count(3)->create();
    Post::factory()->draft()->count(2)->create();
    Post::factory()->archived()->count(1)->create();
    
    $response = $this->get('/posts');
    $posts = $response->viewData('posts');
    
    expect($posts)->toHaveCount(3);
    $posts->each(function ($post) {
        expect($post->status)->toBe('published');
    });
});

test('posts index includes user relationships', function () {
    $user = User::factory()->create(['name' => 'Test Author']);
    Post::factory()->published()->create(['user_id' => $user->id]);
    
    $response = $this->get('/posts');
    
    $response->assertSee('Test Author');
});

test('posts index is paginated', function () {
    Post::factory()->published()->count(20)->create();
    
    $response = $this->get('/posts');
    $posts = $response->viewData('posts');
    
    expect($posts)->toHaveCount(15); // Default pagination limit
    expect($posts->hasPages())->toBeTrue();
});

test('guests can view published post by slug', function () {
    $post = Post::factory()->published()->create(['slug' => 'test-post']);
    
    $response = $this->get('/posts/test-post');
    
    $response->assertOk();
    $response->assertSee($post->title);
    $response->assertSee($post->content);
});

test('guests cannot view draft posts by slug', function () {
    $post = Post::factory()->draft()->create(['slug' => 'draft-post']);
    
    $response = $this->get('/posts/draft-post');
    
    $response->assertNotFound();
});

test('guests cannot view archived posts by slug', function () {
    $post = Post::factory()->archived()->create(['slug' => 'archived-post']);
    
    $response = $this->get('/posts/archived-post');
    
    $response->assertNotFound();
});

test('slug regex validation excludes create', function () {
    $response = $this->get('/posts/create');
    
    // Should not match the public show route
    $response->assertRedirect('/login');
});

test('numeric IDs redirect to login for protected route', function () {
    $response = $this->get('/posts/123');
    
    // Numeric IDs should match the protected admin route and redirect to login
    $response->assertRedirect('/login');
});

test('public post view includes user relationship', function () {
    $user = User::factory()->create(['name' => 'Post Author']);
    $post = Post::factory()->published()->create([
        'user_id' => $user->id,
        'slug' => 'test-post'
    ]);
    
    $response = $this->get('/posts/test-post');
    
    $response->assertSee('Post Author');
});

// Protected Routes Authentication Tests
test('create post form requires authentication', function () {
    $response = $this->get('/posts/create');
    
    $response->assertRedirect('/login');
});

test('store post requires authentication', function () {
    $response = $this->post('/posts', [
        'title' => 'Test Post',
        'content' => 'Test content',
        'status' => 'draft'
    ]);
    
    $response->assertRedirect('/login');
});

test('edit post form requires authentication', function () {
    $post = Post::factory()->create();
    
    $response = $this->get("/posts/{$post->id}/edit");
    
    $response->assertRedirect('/login');
});

test('update post requires authentication', function () {
    $post = Post::factory()->create();
    
    $response = $this->put("/posts/{$post->id}", [
        'title' => 'Updated Title',
        'content' => 'Updated content',
        'status' => 'published'
    ]);
    
    $response->assertRedirect('/login');
});

test('delete post requires authentication', function () {
    $post = Post::factory()->create();
    
    $response = $this->delete("/posts/{$post->id}");
    
    $response->assertRedirect('/login');
});

test('show post admin view requires authentication', function () {
    $post = Post::factory()->create();
    
    $response = $this->get("/posts/{$post->id}");
    
    $response->assertRedirect('/login');
});

// Authenticated User CRUD Tests
test('authenticated user can view create form', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/posts/create');
    
    $response->assertOk();
    $response->assertSee('Create Post');
});

test('authenticated user can create post', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'New Test Post',
        'content' => 'This is test content for the new post.',
        'excerpt' => 'Test excerpt',
        'status' => 'draft',
        'is_featured' => false
    ]);
    
    $response->assertRedirect();
    
    $this->assertDatabaseHas('posts', [
        'title' => 'New Test Post',
        'content' => 'This is test content for the new post.',
        'status' => 'draft',
        'user_id' => $user->id
    ]);
});

test('post creation generates slug automatically', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)->post('/posts', [
        'title' => 'This is a Test Post Title',
        'content' => 'Test content',
        'status' => 'draft'
    ]);
    
    $this->assertDatabaseHas('posts', [
        'title' => 'This is a Test Post Title',
        'slug' => 'this-is-a-test-post-title'
    ]);
});

test('post creation handles duplicate slugs', function () {
    $user = User::factory()->create();
    
    // Create first post
    $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'status' => 'draft'
    ]);
    
    // Create second post with same title
    $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Different content',
        'status' => 'draft'
    ]);
    
    $this->assertDatabaseHas('posts', ['slug' => 'test-title']);
    $this->assertDatabaseHas('posts', ['slug' => 'test-title-1']);
});

test('authenticated user can view edit form', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    $response = $this->actingAs($user)->get("/posts/{$post->id}/edit");
    
    $response->assertOk();
    $response->assertSee($post->title);
    $response->assertSee($post->content);
});

test('authenticated user can update post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    $response = $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Updated Post Title',
        'content' => 'Updated content',
        'excerpt' => 'Updated excerpt',
        'status' => 'published',
        'is_featured' => true
    ]);
    
    $response->assertRedirect();
    
    $post->refresh();
    expect($post->title)->toBe('Updated Post Title');
    expect($post->content)->toBe('Updated content');
    expect($post->status)->toBe('published');
    expect($post->is_featured)->toBeTrue();
});

test('post update regenerates slug when title changes', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'title' => 'Original Title',
        'slug' => 'original-title'
    ]);
    
    $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'New Title',
        'content' => $post->content,
        'status' => $post->status
    ]);
    
    $post->refresh();
    expect($post->slug)->toBe('new-title');
});

test('post update keeps slug when title unchanged', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'title' => 'Same Title',
        'slug' => 'same-title'
    ]);
    
    $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Same Title',
        'content' => 'Updated content only',
        'status' => $post->status
    ]);
    
    $post->refresh();
    expect($post->slug)->toBe('same-title');
});

test('authenticated user can delete post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    $response = $this->actingAs($user)->delete("/posts/{$post->id}");
    
    $response->assertRedirect();
    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

test('authenticated user can view admin post details', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    $response = $this->actingAs($user)->get("/posts/{$post->id}");
    
    $response->assertOk();
    $response->assertSee($post->title);
});

// Validation Tests
test('post creation validates required fields', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', []);
    
    $response->assertSessionHasErrors(['title', 'content', 'status']);
});

test('post creation validates title length', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => str_repeat('a', 256), // Exceeds 255 character limit
        'content' => 'Test content',
        'status' => 'draft'
    ]);
    
    $response->assertSessionHasErrors(['title']);
});

test('post creation validates excerpt length', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'excerpt' => str_repeat('a', 501), // Exceeds 500 character limit
        'status' => 'draft'
    ]);
    
    $response->assertSessionHasErrors(['excerpt']);
});

test('post creation validates meta_title length', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'meta_title' => str_repeat('a', 256), // Exceeds 255 character limit
        'status' => 'draft'
    ]);
    
    $response->assertSessionHasErrors(['meta_title']);
});

test('post creation validates meta_description length', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'meta_description' => str_repeat('a', 301), // Exceeds 300 character limit
        'status' => 'draft'
    ]);
    
    $response->assertSessionHasErrors(['meta_description']);
});

test('post creation validates status enum', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'status' => 'invalid_status'
    ]);
    
    $response->assertSessionHasErrors(['status']);
});

test('post creation validates featured_image url format', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'featured_image' => 'not-a-valid-url',
        'status' => 'draft'
    ]);
    
    $response->assertSessionHasErrors(['featured_image']);
});

test('post creation validates published_at date format', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'published_at' => 'not-a-date',
        'status' => 'published'
    ]);
    
    $response->assertSessionHasErrors(['published_at']);
});

test('post creation validates is_featured boolean', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Title',
        'content' => 'Test content',
        'is_featured' => 'not-boolean',
        'status' => 'draft'
    ]);
    
    $response->assertSessionHasErrors(['is_featured']);
});

// Status Management Tests
test('published posts have published_at timestamp', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)->post('/posts', [
        'title' => 'Published Post',
        'content' => 'Content',
        'status' => 'published'
    ]);
    
    $post = Post::where('title', 'Published Post')->first();
    expect($post->published_at)->not->toBeNull();
});

test('draft posts do not have published_at timestamp', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)->post('/posts', [
        'title' => 'Draft Post',
        'content' => 'Content',
        'status' => 'draft'
    ]);
    
    $post = Post::where('title', 'Draft Post')->first();
    expect($post->published_at)->toBeNull();
});

test('changing draft to published sets published_at', function () {
    $user = User::factory()->create();
    $post = Post::factory()->draft()->create(['user_id' => $user->id]);
    
    $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => $post->title,
        'content' => $post->content,
        'status' => 'published'
    ]);
    
    $post->refresh();
    expect($post->published_at)->not->toBeNull();
});

test('user_id is automatically set to authenticated user', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)->post('/posts', [
        'title' => 'Auto User Post',
        'content' => 'Content',
        'status' => 'draft'
    ]);
    
    $post = Post::where('title', 'Auto User Post')->first();
    expect($post->user_id)->toBe($user->id);
});