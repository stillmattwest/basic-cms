<?php

use App\Models\User;

test('it includes language dropdown in wysiwyg editor', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('posts.create'));
    
    $response->assertOk();
    // Check for language dropdown in toolbar configuration
    $response->assertSee('code-language', false);
    $response->assertSee('javascript', false);
    $response->assertSee('php', false);
});

test('it includes wysiwyg editor language options', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('posts.create'));
    
    $response->assertOk();
    // Check for language options in the JavaScript
    $response->assertSee('languageOptions', false);
    $response->assertSee('JavaScript', false);
    $response->assertSee('PHP', false);
    $response->assertSee('Plain Text', false);
});