<?php

use App\Models\Post;

test('it converts quill code blocks and loads highlight.js', function () {
    $post = Post::factory()->create([
        'content' => '<div><div>function test() {</div><div>  return true;</div><div>}</div></div>',
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('<pre><code>', false);
    $response->assertSee('function test()', false);
    $response->assertSee('hljs.highlightAll', false);
});

test('it preserves regular content and ignores non-code divs', function () {
    $post = Post::factory()->create([
        'content' => '<p>Regular text</p><div><p>This is not code</p></div>',
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('Regular text', false);
    $response->assertSee('This is not code', false);
    $response->assertDontSee('<pre><code>', false);
});