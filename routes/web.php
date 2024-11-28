<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

use Illuminate\Support\Facades\Auth;



use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('categories', CategoryController::class);


Route::resource('posts', PostController::class);


Route::get('posts/search', [PostController::class, 'search'])->name('posts.search');
// Search route (assuming you have a 'search' method in the PostController)
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');





Route::get('register', [AuthController::class, 'showRegisterForm'])->name('registerForm');
Route::post('register', [AuthController::class, 'register']);

Route::get('login', [AuthController::class, 'showLoginForm'])->name('loginForm');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);