<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::get('/users', function () {
    return view('auth.users'); // Ensure this matches the correct path
})->name('users.view');

Route::get('/users', [UserController::class, 'index'])->name('users');


// Redirect Home Page to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password Routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password Routes
    Route::get('/reset-password', [PasswordResetLinkController::class, 'createResetPassword'])->name('password.reset.form');
    Route::post('/reset-password', [PasswordResetLinkController::class, 'resetPassword'])->name('password.reset');
});

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Dashboard Route (Check if session token exists)
Route::get('/dashboard', function () {
    if (!session()->has('api_token')) {
        return redirect()->route('login')->withErrors(['error' => 'Please log in first']);
    }
    return view('auth.dashboard'); // Make sure you have auth.dashboard.blade.php
})->name('dashboard');

// Update user
Route::get('/users/{id}', [UserController::class, 'getUser']);

Route::put('/users/update/{id}', [UserController::class, 'updateUser'])->name('user.update');

Route::post('/users/register', [AuthenticatedSessionController::class, 'register']);

// Include authentication-related routes (registration, password reset, etc.)
require __DIR__.'/auth.php';
