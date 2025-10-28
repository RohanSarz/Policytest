<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDataController;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'posts')->name('home');
Route::resource('posts', PostController::class)->parameters(['posts' => 'post']);
Route::get('/categories/{category}', [PostController::class, 'byCategory'])->name('categories.show');

// Auth routes
Route::middleware(['auth'])->group(function () {
    // User own profile routes
    Route::get('/dashboard', [UserDataController::class, 'dashboardView'])->name('dashboard');
    Route::get('/profile', [UserDataController::class, 'profileView'])->name('profile');
    Route::post('/profile', [UserDataController::class, 'store'])->name('profile.store');
    Route::post('/profile/avatar', [UserDataController::class, 'updateAvatar'])->name('profile.avatar.update');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User profile route for viewing other users
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

// Guest routes
Route::middleware(['guest'])->group(function () {
    // Login or Register Routes
    Route::inertia('/login', 'Auth/Login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::inertia('/register', 'Auth/Register', [
        'defUrl' => Storage::url('avatars/def.jpg'),
    ]);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/roles', [AdminController::class, 'getRoles'])->name('admin.roles');
    Route::get('/admin/settings', [AdminController::class, 'settingsView'])->name('admin.settings');
});
