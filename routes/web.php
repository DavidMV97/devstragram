<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('principal');
});

Route::get('/register', [RegisterController::class, 'index'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

Route::get('/{user:username}', [PostController::class, 'index'])
    ->name('post.index');

Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create')->middleware('auth'); 

Route::post('/posts', [PostController::class, 'store'])->name('posts.store'); 

Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');