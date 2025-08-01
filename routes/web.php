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

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public post routes (must be after resource routes to avoid conflicts)
Route::get('/posts/{slug}', [PostController::class, 'showBySlug'])
    ->name('posts.public.show')
    ->where('slug', '^(?!create$|[0-9]+$)[a-z0-9-]+$');

require __DIR__.'/auth.php';
