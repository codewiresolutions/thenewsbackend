<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\AdvertisementController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories/store', [CategoryController::class, 'store']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::post('categories/{id}', [CategoryController::class, 'update']);
Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
Route::get('posts-by-category/{id}', [CategoryController::class, 'postsByCategory']);




Route::get('posts', [PostController::class, 'index']); // Get all posts
Route::get('posts/{id}', [PostController::class, 'show']); // Get a single post by ID
Route::post('posts/store', [PostController::class, 'store']);
Route::post('posts/{id}', [PostController::class, 'update']); // Update a post
Route::delete('posts/{id}', [PostController::class, 'destroy']); // Delete a post




Route::post('/register', [AuthController::class, 'register']); // User registration
Route::post('/login', [AuthController::class, 'login']);       // User login
Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
Route::post('/reset-password/{otp}', [PasswordResetController::class, 'reset']);

// Protected Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // User logout
    Route::get('/logged-user', [AuthController::class, 'logged_user']); // User looged
    Route::get('/change-password', [AuthController::class, 'change_password']); // User logout


});


Route::get('tags', [TagController::class, 'index']); // Get all tags
Route::post('tags', [TagController::class, 'store']); // Create a new tag
Route::get('tags/{id}', [TagController::class, 'show']); // Get a specific tag by ID
Route::put('tags/{id}', [TagController::class, 'update']); // Update a specific tag by ID
Route::delete('tags/{id}', [TagController::class, 'destroy']); // Delete a specific tag by ID










Route::post('advertisements', [AdvertisementController::class, 'store']);
Route::post('advertisements/{advertisement}', [AdvertisementController::class, 'update']);
Route::delete('advertisements/{advertisement}', [AdvertisementController::class, 'destroy']);
Route::get('advertisements', [AdvertisementController::class, 'index']);
Route::get('advertisements/{advertisement}', [AdvertisementController::class, 'show']);




Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/{id}', [AuthorController::class, 'show']);
Route::post('authors', [AuthorController::class, 'store']);
Route::put('authors/{id}', [AuthorController::class, 'update']);
Route::delete('authors/{id}', [AuthorController::class, 'destroy']);





// Separate route definitions
Route::get('articles', [ArticleController::class, 'index']); // List all articles
Route::get('articles/{id}', [ArticleController::class, 'show']); // Show a single article
Route::post('articlesstore', [ArticleController::class, 'store']);

Route::put('articles/{id}', [ArticleController::class, 'update']); // Update an existing article
Route::delete('articles/{id}', [ArticleController::class, 'destroy']); // Delete an article
