<?php

use App\Models\User;

test('wysiwyg editor includes code-block functionality', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('posts.create'));
    
    $response->assertOk();
    $response->assertSee('code-block', false);
    $response->assertSee('window.hljs', false);
    $response->assertSee('initCodeBlockHighlighting', false);
});