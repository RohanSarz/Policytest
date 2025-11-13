<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'posts')->name('home');

// Image upload route for TinyMCE
Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('image.upload');

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
    Route::inertia('/login', 'Auth/Login')->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::inertia('/register', 'Auth/Register')->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/roles', [AdminController::class, 'roles'])->name('admin.roles.index');
        Route::post('/roles', [AdminController::class, 'storeRole'])->name('admin.roles.store');
        Route::put('/roles/{role}', [AdminController::class, 'updateRole'])->name('admin.roles.update');
        Route::delete('/roles/{role}', [AdminController::class, 'deleteRole'])->name('admin.roles.destroy');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');
        Route::get('/permissions', [AdminController::class, 'permissions'])->name('admin.permissions.index');
        Route::post('/permissions', [AdminController::class, 'storePermission'])->name('admin.permissions.store');
        Route::get('/posts', [AdminController::class, 'posts'])->name('admin.posts.index');
        Route::patch('/posts/{post}/status', [AdminController::class, 'updatePostStatus'])->name('admin.posts.status.update');
    });
