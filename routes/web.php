<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Redirect Home Page to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// =========================
// Authentication Routes
// =========================
Route::middleware('guest')->group(function () {
    // Routes for login, password reset, and registration
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
// Route to fetch dashboard counts
Route::get('/dashboard/get-counts', [DashboardController::class, 'getCounts']);
Route::get('/dashboard/fetch-counts', [DashboardController::class, 'fetchCounts'])->name('dashboard.fetchCounts');

// =========================
// User Management Routes
// =========================
// Routes for managing users (list, update, register)
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/{id}', [UserController::class, 'getUser']);
Route::put('/users/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
Route::post('/users/register', [AuthenticatedSessionController::class, 'register']);

// =========================
// Client Management Routes
// =========================
// Routes for managing clients (list, fetch, search, archive, etc.)
// List all clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.list');

// Fetch all clients
Route::get('/clients/fetch', [ClientController::class, 'fetchClients'])->name('clients.fetch');

// Search clients
Route::get('/clients/search', [ClientController::class, 'searchClients'])->name('clients.search');

// Archive a client
Route::post('/clients/archive', [ClientController::class, 'archiveClient'])->name('clients.archiveClient');

// Filter clients
Route::get('/clients/filter', [ClientController::class, 'filterClients'])->name('clients.filter');

// View archived clients
Route::get('/clients/archive', [ClientController::class, 'archive'])->name('clients.archive');

// Add a new client
Route::get('/clients/add-client', function () {
    return view('clients.add-client');
})->name('clients.add');
Route::post('/clients/add-client', [ClientController::class, 'addClient'])->name('clients.store');

// View client details
Route::get('/clients/{id}', [ClientController::class, 'showClient'])->name('clients.show');

// Fetch archived clients
Route::get('/clients/archived', [ClientController::class, 'fetchArchivedClients'])->name('clients.archived');

// Unarchive a client
Route::put('/clients/unarchive', [ClientController::class, 'unarchiveClient'])->name('clients.unarchive');

// Edit client (show edit form)
Route::get('/clients/{id}/edit', [ClientController::class, 'editClient'])->name('clients.edit');
// Update client (handle form submission)
Route::put('/clients/{id}', [ClientController::class, 'updateClient'])->name('clients.update');

// Add Note to Client
Route::post('/clients/{id}/add-note', [ClientController::class, 'addNoteToClient'])->name('clients.addNote');

// =========================
// Task Management Routes
// =========================
// Routes for managing tasks
Route::get('/task', [TaskController::class, 'index'])->name('task');
// Search tasks
Route::get('/task/search', [TaskController::class, 'searchTasks'])->name('task.search');
// Store tasks
Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
    
// =========================
// Include Authentication-Related Routes
// =========================
require __DIR__.'/auth.php';