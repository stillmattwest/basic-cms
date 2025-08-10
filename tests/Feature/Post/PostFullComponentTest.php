<?php

use App\Models\Post;

test('post-full component renders and processes code blocks', function () {
    $post = Post::factory()->create([
        'content' => '<div><div>function hello() {</div><div>  console.log("world");</div><div>}</div></div>',
        'status' => 'published'
    ]);
    
    $response = $this->get(route('posts.public.show', $post->slug));
    
    $response->assertOk();
    $response->assertSee('<pre><code>', false);
    $response->assertSee('function hello()', false);
    $response->assertSee('hljs.highlightAll()', false);
});