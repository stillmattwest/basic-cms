<?php

use App\Models\Post;

test('post pages include highlight.js theme link', function () {
    $post = Post::factory()->create([
        'content' => '<div><div>function test() {</div><div>  return true;</div><div>}</div></div>',
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('css/highlight/light.css', false);
    $response->assertSee('id="hljs-theme"', false);
});

test('post pages include theme switching javascript', function () {
    $post = Post::factory()->create(['status' => 'published']);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('updateHighlightTheme', false);
    $response->assertSee('theme-changed', false);
    $response->assertSee('css/highlight/dark.css', false);
    $response->assertSee('css/highlight/light.css', false);
});