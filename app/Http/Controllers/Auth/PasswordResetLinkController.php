<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $email = strtolower($request->email);

            // Log the request payload for debugging
            Log::info('Forgot Password API Request', ['email' => $email]);

            // Send the password reset request to the API
            $response = Http::withHeaders([
                'Authorization' => '1234',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('http://192.168.1.9:2030/api/Auth/forgot-password', [
                'email' => $email,
            ]);

            // Log the API response for debugging
            Log::info('Forgot Password API Response', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Password reset link sent successfully. Please check your email.');
            }

            return back()->withErrors(['email' => 'Failed to send password reset link.']);
        } catch (\Exception $e) {
            Log::error('Forgot Password API Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}