<?php

use App\Models\Post;

test('it preserves code blocks in post content', function () {
    $post = Post::factory()->create([
        'content' => '<div><div>function test() {</div><div>  return true;</div><div>}</div></div>',
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('function test()');
    $response->assertSee('return true;');
});

test('it loads prism javascript on post pages', function () {
    $post = Post::factory()->create([
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('prism.min.js', false); // false = don't escape HTML
});

test('it includes post content container with correct id', function () {
    $post = Post::factory()->create([
        'content' => '<div><div>console.log("hello");</div></div>',
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('id="post-content"', false);
    $response->assertSee('console.log');
});

test('it includes syntax highlighting script on post pages', function () {
    $post = Post::factory()->create([
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    // Check for our custom JavaScript that converts code blocks
    $response->assertSee('getElementById(\'post-content\')', false);
    $response->assertSee('Prism.highlightElement', false);
});