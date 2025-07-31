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
Route::get('/posts/{slug}', [PostController::class, 'showBySlug'])->name('posts.public.show');


// Protected routes (authentication required)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Post management routes
    Route::resource('posts', PostController::class);

    // Image upload routes for WYSIWYG editor
    Route::post('/images/upload', [ImageController::class, 'upload'])->name('images.upload');
    Route::delete('/images/delete', [ImageController::class, 'delete'])->name('images.delete');

    // Admin routes
    Route::get('/admin/create-post', function () {
        return view('admin.create-post');
    })->name('create-post');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
