<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;


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
Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);

// Protected Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // User logout
    Route::get('/logged-user', [AuthController::class, 'logged_user']); // User looged
    Route::get('/change-password', [AuthController::class, 'change_password']); // User logout

});
