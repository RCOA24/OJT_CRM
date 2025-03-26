<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'newPassword' => ['required', 'min:8', 'confirmed'], // Match the form field names
        ]);

        try {
            // Validate the token with the API
            $response = Http::withHeaders([
                'Authorization' => '1234', // Authorization token as per Swagger
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('http://192.168.1.9:2030/api/Auth/validate-token', [
                'email' => $request->email,
                'token' => $request->token,
            ]);

            if ($response->failed()) {
                return back()->withErrors(['token' => 'Invalid or expired token. Please request a new password reset link.']);
            }

            // Reset the password via the API
            $resetResponse = Http::withHeaders([
                'Authorization' => '1234',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('http://192.168.1.9:2030/api/Auth/reset-password', [
                'email' => $request->email,
                'password' => $request->newPassword,
            ]);

            if ($resetResponse->successful()) {
                return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
            } else {
                $errorMessage = $resetResponse->json()['message'] ?? 'An error occurred while resetting your password.';
                return back()->withErrors(['email' => $errorMessage]);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Password Reset Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}
