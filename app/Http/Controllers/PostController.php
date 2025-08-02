<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of posts
     */
    public function index()
    {
        $posts = Post::with('user')
            ->published()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post
     */
    public function create()
    {
        return view('posts.create-post');
    }

    /**
     * Store a newly created post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:300',
            'featured_image' => 'nullable|url',
            'featured_image_alt' => 'nullable|max:255',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Generate slug from title with additional sanitization
        $cleanTitle = strip_tags($validated['title']); // Remove HTML tags
        // Remove suspicious words before removing special chars
        $cleanTitle = preg_replace('/(alert|script|eval|javascript|vbscript|onload|onerror)/i', '', $cleanTitle);
        $cleanTitle = preg_replace('/[^\w\s-]/', '', $cleanTitle); // Remove special chars except word chars, spaces, hyphens
        $validated['slug'] = Str::slug($cleanTitle);

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Post::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set published_at if status is published
        if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        // Assign current user
        if (!Auth::check()) {
            return back()->withErrors(['error' => 'You must be logged in to create a post.']);
        }

        $validated['user_id'] = Auth::id();

        $post = Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified post
     */
    public function show(Post $post)
    {
        $post->load('user');
        return view('posts.post', compact('post'));
    }

    /**
     * Show the form for editing the specified post
     */
    public function edit(Post $post)
    {
        // Check if user can edit this post
        // $this->authorize('update', $post);

        return view('posts.edit-post', compact('post'));
    }

    /**
     * Update the specified post
     */
    public function update(Request $request, Post $post)
    {
        // Check if user can update this post
        // $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:300',
            'featured_image' => 'nullable|url',
            'featured_image_alt' => 'nullable|max:255',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        // Update slug if title changed
        if ($validated['title'] !== $post->title) {
            $cleanTitle = strip_tags($validated['title']); // Remove HTML tags
            // Remove suspicious words before removing special chars
            $cleanTitle = preg_replace('/(alert|script|eval|javascript|vbscript|onload|onerror)/i', '', $cleanTitle);
            $cleanTitle = preg_replace('/[^\w\s-]/', '', $cleanTitle); // Remove special chars except word chars, spaces, hyphens
            $validated['slug'] = Str::slug($cleanTitle);

            // Ensure slug is unique (excluding current post)
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Post::where('slug', $validated['slug'])->where('id', '!=', $post->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Set published_at if changing to published and not already set
        if ($validated['status'] === 'published' && !$post->published_at && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post
     */
    public function destroy(Post $post)
    {
        // Check if user can delete this post
        // $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Display posts by slug (for public viewing)
     */
    public function showBySlug($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with('user')
            ->firstOrFail();

        return view('posts.post', compact('post'));
    }
}
