<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserDataController;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'posts')->name('home');
Route::resource('posts', PostController::class);

// User routes
Route::middleware(['auth'])->group(function () {
    Route::inertia('/dashboard', 'User/Dashboard')->name('dashboard');
    Route::get('/profile', [UserDataController::class, 'profileView'])->name('profile');
    Route::post('/profile', [UserDataController::class, 'store'])->name('profile.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    // Login or Register Routes
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::inertia('/register', 'Auth/Register', [
        'defUrl' => Storage::url('avatars/def.jpg'),
    ])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
