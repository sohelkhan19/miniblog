<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

Route::get('/', [BlogPostController::class, 'index'])->name('home');
Route::get('/post/{id}', [BlogPostController::class, 'show'])->name('blog.show');

Route::get('/dashboard', function () {
    return redirect()->route('home'); // or return a view if you want
})->middleware(['auth'])->name('dashboard');


// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/create', [BlogPostController::class, 'create'])->name('blog.create');
    Route::post('/store', [BlogPostController::class, 'store'])->name('blog.store');
    Route::get('/post/{id}/edit', [BlogPostController::class, 'edit'])->name('blog.edit');
    Route::post('/post/{id}/update', [BlogPostController::class, 'update'])->name('blog.update');
    Route::get('/post/{id}/delete', [BlogPostController::class, 'destroy'])->name('blog.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('categories.delete');
});

Route::post('/blog/{id}/like', [App\Http\Controllers\LikeController::class, 'toggle'])->name('blog.toggleLike')->middleware('auth');

Route::post('/blog/{id}/comment', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::get('/my-posts', [BlogPostController::class, 'myPosts'])->name('blog.myPosts');



require __DIR__.'/auth.php';
