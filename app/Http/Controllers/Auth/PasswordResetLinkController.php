<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $email = strtolower($request->email); // Convert email to lowercase for consistency

            // Log the request payload for debugging
            Log::info('Forgot Password API Request', [
                'email' => $email,
            ]);

            // Send the password reset request to the API
            $response = Http::withHeaders([
                'Authorization' => '1234', // Authorization token as per Swagger
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('http://192.168.1.9:2030/api/Auth/forgot-password', [
                'email' => $email,
            ]);

            // Log the API response for debugging
            Log::info('Forgot Password API Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                return back()->with('status', 'Password reset link sent to your email.')
                             ->with('success', 'The password reset email has been sent successfully.');
            } elseif ($response->status() === 404) {
                return back()->withErrors(['email' => 'The email address is not registered in our system. Please ensure you entered the correct email.']);
            } else {
                $errorMessage = $response->json()['message'] ?? 'An error occurred.';
                return back()->withErrors(['email' => 'Error: ' . $errorMessage]);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Forgot Password API Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}
