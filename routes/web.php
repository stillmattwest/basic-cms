<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function () {
    return view('welcome');
});

Route::get('component-library', function () {
    return view('componentLibrary.index');
})->name('component-library');

// Public post routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'showBySlug'])
    ->name('posts.public.show')
    ->where('slug', '^(?!create$|[0-9]+$)[a-z0-9-]+$');

// Protected routes (authentication required)
Route::middleware('auth')->group(function () {
    // Post management routes (except index and public show)
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}', [PostController::class, 'show'])
        ->name('posts.show')
        ->where('post', '[0-9]+');

    // Image upload routes for WYSIWYG editor
    Route::post('/images/upload', [ImageController::class, 'upload'])->name('images.upload');
    Route::delete('/images/delete', [ImageController::class, 'delete'])->name('images.delete');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
