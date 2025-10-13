<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::inertia('/dashboard', 'User/Dashboard')->name('dashboard');
});

Route::middleware(['guest'])->group(function () {
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::inertia('/register', 'Auth/Register', [
        'defUrl' => Storage::url('avatars/def.jpg'),
    ])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
