<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// Redirect Home Page to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// =========================
// Authentication Routes
// =========================
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password Routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset Password Routes
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset.form');
    Route::put('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// =========================
// Dashboard Routes
// =========================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/get-counts', [DashboardController::class, 'getCounts']);

// =========================
// User Management Routes
// =========================
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/{id}', [UserController::class, 'getUser']);
Route::put('/users/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
Route::post('/users/register', [AuthenticatedSessionController::class, 'register']);

// =========================
// Client Management Routes
// =========================

// List all clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.list');

// View archived clients
Route::get('/clients/archive', [ClientController::class, 'archive'])->name('clients.archive');

// Add a new client
Route::get('/clients/add-client', function () {
    return view('clients.add-client');
})->name('clients.add');
Route::post('/clients/add-client', [ClientController::class, 'addClient'])->name('clients.store');

// View client details
Route::get('/clients/{id}', [ClientController::class, 'showClient'])->name('clients.show');

// =========================
// Task Management Routes
// =========================
Route::get('/task', function () {
    return view('task.index'); // Ensure this view exists
})->name('task');

// =========================
// Include Authentication-Related Routes
// =========================
require __DIR__.'/auth.php';