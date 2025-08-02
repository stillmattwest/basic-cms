<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

// Authentication Tests
test('image upload requires authentication', function () {
    $file = UploadedFile::fake()->image('test.jpg');
    
    $response = $this->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertRedirect('/login');
});

test('image delete requires authentication', function () {
    $response = $this->delete('/images/delete', [
        'path' => 'posts/images/2024/01/test.jpg'
    ]);
    
    $response->assertRedirect('/login');
});

test('authenticated user can access upload endpoint', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('test.jpg');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file  // Changed from 'file' to 'image'
    ]);
    
    $response->assertOk();
});

test('authenticated user can access delete endpoint', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->delete('/images/delete', [
        'path' => 'posts/images/nonexistent/path.jpg'
    ]);
    
    // Should return 404 for non-existent file per controller logic  
    $response->assertStatus(404);
    $response->assertJson(['success' => false]);
});

// Upload Validation Tests
test('upload accepts valid JPEG images', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('test.jpg');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertOk();
    $response->assertJson(['success' => true]);
});

test('upload accepts valid PNG images', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('test.png');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertOk();
    $response->assertJson(['success' => true]);
});

test('upload accepts valid GIF images', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('test.gif', 100, 'image/gif');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertOk();
    $response->assertJson(['success' => true]);
});

test('upload accepts valid WEBP images', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('test.webp', 100, 'image/webp');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertOk();
    $response->assertJson(['success' => true]);
});

test('upload rejects text files', function () {
    $user = User::factory()->create();
    $file = new UploadedFile(
        base_path('tests/fixtures/images/invalid-file.txt'),
        'invalid-file.txt',
        'text/plain',
        null,
        true
    );
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertStatus(422);
    $response->assertJson(['success' => false]);
});

test('upload rejects PHP files', function () {
    $user = User::factory()->create();
    $file = new UploadedFile(
        base_path('tests/fixtures/images/malicious-file.php'),
        'malicious-file.php',
        'application/x-httpd-php',
        null,
        true
    );
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertStatus(422);
    $response->assertJson(['success' => false]);
});

test('upload enforces 2MB size limit', function () {
    $user = User::factory()->create();
    $file = new UploadedFile(
        base_path('tests/fixtures/images/large-image.jpg'),
        'large-image.jpg',
        'image/jpeg',
        null,
        true
    );
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertStatus(422);
    $response->assertJson(['success' => false]);
});

test('upload requires image parameter', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/images/upload', []);
    
    $response->assertStatus(422);
    $response->assertJson(['success' => false]);
});

test('upload validates file is actually a file', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'file' => 'not-a-file'
    ]);
    
    $response->assertStatus(422);
    $response->assertJson(['success' => false]);
});

// Upload Functionality Tests
test('successful upload stores file correctly', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('test.jpg', 200, 200);
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertOk();
    $responseData = $response->json();
    
    // Check file exists in storage
    Storage::disk('public')->assertExists($responseData['path']);
    
    // Check path format: posts/images/{year}/{month}
    expect($responseData['path'])->toMatch('/^posts\/images\/\d{4}\/\d{2}\/.+$/');
});

test('successful upload uses UUID filename', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('original-name.jpg');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $responseData = $response->json();
    $filename = basename($responseData['path']);
    
    // UUID pattern: 8-4-4-4-12 hex characters
    expect($filename)->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\.jpg$/');
});

test('successful upload returns correct JSON structure', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('test.jpg');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $response->assertOk();
    $response->assertJsonStructure([
        'success',
        'url',
        'path',
        'filename'
    ]);
    
    $responseData = $response->json();
    expect($responseData['success'])->toBeTrue();
    expect($responseData['url'])->toBeString();
    expect($responseData['path'])->toBeString();
    expect($responseData['filename'])->toBeString();
});

test('uploaded file is accessible via public URL', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('test.jpg');
    
    $response = $this->actingAs($user)->post('/images/upload', [
        'image' => $file
    ]);
    
    $responseData = $response->json();
    
    // Controller uses asset() which creates full URLs
    expect($responseData['url'])->toContain('/storage/');
    expect($responseData['url'])->toContain($responseData['path']);
});

test('upload preserves file extension', function () {
    $user = User::factory()->create();
    $pngFile = UploadedFile::fake()->image('test.png');
    $jpgFile = UploadedFile::fake()->image('test.jpg');
    
    $pngResponse = $this->actingAs($user)->post('/images/upload', ['image' => $pngFile]);
    $jpgResponse = $this->actingAs($user)->post('/images/upload', ['image' => $jpgFile]);
    
    expect($pngResponse->json('path'))->toEndWith('.png');
    expect($jpgResponse->json('path'))->toEndWith('.jpg');
});

test('multiple uploads create unique filenames', function () {
    $user = User::factory()->create();
    $file1 = UploadedFile::fake()->image('test1.jpg');
    $file2 = UploadedFile::fake()->image('test2.jpg');
    
    $response1 = $this->actingAs($user)->post('/images/upload', ['image' => $file1]);
    $response2 = $this->actingAs($user)->post('/images/upload', ['image' => $file2]);
    
    $path1 = $response1->json('path');
    $path2 = $response2->json('path');
    
    expect($path1)->not->toBe($path2);
});

// Delete Functionality Tests
test('delete removes file from storage', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->image('test.jpg');
    
    // Upload file first
    $uploadResponse = $this->actingAs($user)->post('/images/upload', ['image' => $file]);
    $path = $uploadResponse->json('path');
    
    // Verify file exists
    Storage::disk('public')->assertExists($path);
    
    // Delete file
    $deleteResponse = $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->delete('/images/delete', ['path' => $path]);
    
    $deleteResponse->assertOk();
    $deleteResponse->assertJson(['success' => true]);
    
    // Verify file is deleted
    Storage::disk('public')->assertMissing($path);
});

test('delete validates path parameter is required', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->delete('/images/delete', []);
    
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['path']);
});

test('delete validates path parameter is string', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->delete('/images/delete', [
        'path' => ['not', 'a', 'string']
    ]);
    
    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['path']);
});

test('delete handles non-existent files gracefully', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->delete('/images/delete', [
        'path' => 'posts/images/2024/01/nonexistent-file.jpg'
    ]);
    
    // Should return 404 with success: false per controller logic
    $response->assertStatus(404);
    $response->assertJson(['success' => false]);
});


test('delete only works within posts directory', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->delete('/images/delete', [
        'path' => 'outside-posts-directory/file.jpg'
    ]);
    
    // Should return 422 due to security validation (path not in posts/images/)
    $response->assertStatus(422);
});

// Error Handling Tests
test('upload handles corrupted image gracefully', function () {
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('corrupted.jpg', 100, 'image/jpeg');
    
    $response = $this->actingAs($user)->post('/images/upload', ['file' => $file]);
    
    // May succeed or fail depending on validation, but should not crash
    expect($response->status())->toBeIn([200, 422]);
});