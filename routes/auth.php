<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| This file defines authentication-related routes for guest and 
| authenticated users. Routes are grouped with middleware to ensure
| proper access control.
|
*/

// Routes for guests (users who are not authenticated)
Route::middleware('guest')->group(function () {

    // Registration Routes
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register'); // Show registration form
    Route::post('register', [RegisteredUserController::class, 'store']); // Handle registration request

    // Login Routes
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login'); // Show login form
    Route::post('login', [AuthenticatedSessionController::class, 'store']); // Handle login request

    // Password Reset Routes
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request'); // Show forgot password form
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email'); // Send password reset link

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset'); // Show reset password form
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store'); // Handle reset password request
});

// Routes for authenticated users
Route::middleware('auth')->group(function () {

    // Email Verification Routes
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice'); // Show email verification prompt

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1']) // Ensure the link is signed and limit requests
        ->name('verification.verify'); // Handle email verification

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1') // Limit resend requests to 6 per minute
        ->name('verification.send'); // Resend verification email

    // Password Confirmation Routes
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm'); // Show confirm password form
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']); // Handle confirm password request

    // Password Update Route
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update'); // Update password

    // Logout Route
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout'); // Handle logout request
});
