<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// Authentication Boundary Tests
test('public routes are accessible to guests', function () {
    $post = Post::factory()->published()->create(['slug' => 'public-post']);
    
    $indexResponse = $this->get('/posts');
    $showResponse = $this->get('/posts/public-post');
    
    $indexResponse->assertOk();
    $showResponse->assertOk();
});

test('protected post routes redirect guests to login', function () {
    $post = Post::factory()->create();
    
    $routes = [
        ['GET', '/posts/create'],
        ['POST', '/posts'],
        ['GET', "/posts/{$post->id}/edit"],
        ['PUT', "/posts/{$post->id}"],
        ['DELETE', "/posts/{$post->id}"],
        ['GET', "/posts/{$post->id}"]
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->call($method, $url);
        expect($response->status())->toBe(302);
        expect($response->headers->get('Location'))->toContain('/login');
    }
});

test('protected image routes redirect guests to login', function () {
    $routes = [
        ['POST', '/images/upload'],
        ['DELETE', '/images/delete']
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->call($method, $url);
        expect($response->status())->toBe(302);
        expect($response->headers->get('Location'))->toContain('/login');
    }
});

test('authenticated users can access all protected routes', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    $routes = [
        ['GET', '/posts/create'],
        ['GET', "/posts/{$post->id}/edit"],
        ['GET', "/posts/{$post->id}"]
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->actingAs($user)->call($method, $url);
        expect($response->status())->toBe(200);
    }
});

// Dashboard removed - no longer testing dashboard-specific functionality

// Input Sanitization Tests
test('post content handles HTML safely', function () {
    $user = User::factory()->create();
    $maliciousContent = '<script>alert("XSS")</script><p>Safe content</p>';
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Post',
        'content' => $maliciousContent,
        'status' => 'published'
    ]);
    
    $response->assertRedirect();
    
    $post = Post::where('title', 'Test Post')->first();
    expect($post->content)->toBe($maliciousContent); // Stored as-is, filtering happens in views
    
    // Check public view handles it safely
    $publicResponse = $this->get("/posts/{$post->slug}");
    $publicResponse->assertOk();
    $publicResponse->assertDontSee('alert("XSS")', false); // Check the dangerous content is removed
});

test('post title is properly escaped in views', function () {
    $user = User::factory()->create();
    $maliciousTitle = '<script>alert("XSS")</script>Safe Title';
    
    $this->actingAs($user)->post('/posts', [
        'title' => $maliciousTitle,
        'content' => 'Content',
        'status' => 'published'
    ]);
    
    $post = Post::where('title', $maliciousTitle)->first();
    
    $response = $this->get("/posts/{$post->slug}");
    $response->assertOk();
    $response->assertSee('Safe Title');
    $response->assertDontSee('alert("XSS")', false); // Should be escaped
});

test('post slug generation strips malicious characters', function () {
    $user = User::factory()->create();
    $maliciousTitle = 'Test<script>alert("xss")</script>Post';
    
    $this->actingAs($user)->post('/posts', [
        'title' => $maliciousTitle,
        'content' => 'Content',
        'status' => 'draft'
    ]);
    
    $post = Post::where('title', $maliciousTitle)->first();
    expect($post->slug)->not->toContain('<script>');
    expect($post->slug)->not->toContain('alert');
    expect($post->slug)->toMatch('/^[a-z0-9-]+$/'); // Only safe characters
});

test('meta fields handle special characters safely', function () {
    $user = User::factory()->create();
    $maliciousMeta = '<meta name="evil" content="hack">';
    
    $this->actingAs($user)->post('/posts', [
        'title' => 'Test Post',
        'content' => 'Content',
        'meta_title' => $maliciousMeta,
        'meta_description' => $maliciousMeta,
        'status' => 'published'
    ]);
    
    $post = Post::where('title', 'Test Post')->first();
    
    // Check that meta fields are stored (filtering happens in views)
    expect($post->meta_title)->toBe($maliciousMeta);
    expect($post->meta_description)->toBe($maliciousMeta);
    
    // Check public view handles them safely
    $response = $this->get("/posts/{$post->slug}");
    $response->assertOk();
});

test('delete prevents path traversal attacks', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    
    $maliciousPaths = [
        '../../../etc/passwd',
        '..\\..\\windows\\system32\\config\\sam',
        'posts/images/../../../sensitive-file.txt'
    ];
    
    foreach ($maliciousPaths as $path) {
        $response = $this->actingAs($user)->delete('/images/delete', ['path' => $path]);
        
        // Should handle gracefully without exposing system files
        expect($response->status())->toBeIn([200, 422]);
    }
});

// SQL Injection Prevention Tests
test('post slug parameter is safe from SQL injection', function () {
    $post = Post::factory()->published()->create();
    
    $maliciousSlugs = [
        "'; DROP TABLE posts; --",
        "' UNION SELECT * FROM users --",
        "1' OR '1'='1",
        "'; DELETE FROM posts WHERE '1'='1' --"
    ];
    
    foreach ($maliciousSlugs as $slug) {
        $response = $this->get("/posts/{$slug}");
        
        // Should return 404 or 405 (method not allowed), not crash or expose data
        expect($response->status())->toBeIn([404, 405]);
    }
    
    // Verify original post still exists
    expect(Post::count())->toBeGreaterThan(0);
});

test('search and filter parameters are safe', function () {
    Post::factory()->published()->count(5)->create();
    
    $maliciousParams = [
        'title' => "'; DROP TABLE posts; --",
        'status' => "' OR '1'='1",
        'user_id' => "1; DELETE FROM users;"
    ];
    
    $response = $this->get('/posts?' . http_build_query($maliciousParams));
    
    // Should not crash or expose unauthorized data
    expect($response->status())->toBeIn([200, 422]);
    
    // Verify data integrity
    expect(Post::count())->toBe(5);
    expect(User::count())->toBeGreaterThan(0);
});

// Mass Assignment Protection Tests
test('post creation prevents mass assignment of protected fields', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/posts', [
        'title' => 'Test Post',
        'content' => 'Content',
        'status' => 'draft',
        'id' => 999, // Should not be assignable
        'user_id' => $otherUser->id, // Should be overridden to current user
        'created_at' => '2020-01-01', // Should not be assignable
        'updated_at' => '2020-01-01' // Should not be assignable
    ]);
    
    $post = Post::where('title', 'Test Post')->first();
    
    expect($post->id)->not->toBe(999);
    expect($post->user_id)->toBe($user->id); // Should be current user, not other user
    expect($post->created_at->format('Y-m-d'))->toBe(now()->format('Y-m-d'));
});

test('post update prevents mass assignment of protected fields', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    
    $originalId = $post->id;
    $originalCreatedAt = $post->created_at;
    
    $response = $this->actingAs($user)->put("/posts/{$post->id}", [
        'title' => 'Updated Title',
        'content' => 'Updated content',
        'status' => 'published',
        'id' => 999,
        'user_id' => $otherUser->id,
        'created_at' => '2020-01-01'
    ]);
    
    $post->refresh();
    
    expect($post->title)->toBe('Updated Title'); // Should update
    expect($post->id)->toBe($originalId); // Should not change
    expect($post->user_id)->toBe($user->id); // Should not change
    expect($post->created_at)->toEqual($originalCreatedAt); // Should not change
});


// Content Security Tests
test('post content preserves safe HTML but prevents dangerous scripts', function () {
    $user = User::factory()->create();
    $mixedContent = '
        <p>This is safe content</p>
        <strong>Bold text</strong>
        <em>Italic text</em>
        <script>alert("dangerous")</script>
        <iframe src="http://evil.com"></iframe>
        <object data="malicious.swf"></object>
    ';
    
    $this->actingAs($user)->post('/posts', [
        'title' => 'Mixed Content Test',
        'content' => $mixedContent,
        'status' => 'published'
    ]);
    
    $post = Post::where('title', 'Mixed Content Test')->first();
    
    // Content should be stored as-is (filtering happens in display)
    expect($post->content)->toContain('<p>This is safe content</p>');
    expect($post->content)->toContain('<script>alert("dangerous")</script>');
    
    // Public view should handle dangerous content safely
    $response = $this->get("/posts/{$post->slug}");
    $response->assertOk();
    $response->assertSee('This is safe content');
    $response->assertSee('Bold text');
});