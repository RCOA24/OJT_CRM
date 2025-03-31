<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View; // Use the correct View contract
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        try {
            // Prepare the payload to match ResetPasswordDto schema
            $payload = [
                'token' => $request->token,
                'email' => $request->email,
                'newPassword' => $request->password,
                'confirmPassword' => $request->password_confirmation,
            ];

            // Log the payload for debugging
            Log::info('Reset Password Request Payload', $payload);

            // Send the request to the API
            $resetResponse = Http::withHeaders([
                'Authorization' => '1234',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('http://192.168.1.9:2030/api/Auth/reset-password', $payload);

            // Log the API response for debugging
            Log::info('Reset Password API Response', [
                'status' => $resetResponse->status(),
                'body' => $resetResponse->json() ?? $resetResponse->body(),
            ]);

            // Handle the API response
            if ($resetResponse->successful()) {
                Log::info('Password reset confirmed by API', [
                    'email' => $request->email,
                ]);
                return redirect()->route('login')->with('status', 'Your password has been reset successfully.');
            } else {
                $errorMessage = $resetResponse->json()['message'] ?? 'An error occurred while resetting your password.';
                Log::error('Reset Password Failed', [
                    'status' => $resetResponse->status(),
                    'error' => $errorMessage,
                ]);
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
