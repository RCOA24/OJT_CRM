<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ResetPasswordController extends Controller
{
    public function create(string $token, string $email): View
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        try {
            // Send the reset password request to the API
            $response = Http::withHeaders([
                'Authorization' => '1234', // Authorization token as per Swagger
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->put('http://192.168.1.9:2030/api/Auth/reset-password', [
                'token' => $request->token,
                'email' => $request->email,
                'newPassword' => $request->password,
            ]);

            // Log the API response for debugging
            Log::info('Reset Password API Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                // Redirect to the login page with a success message
                return redirect()->route('login')->with('success', 'Password reset successfully. Please log in with your new password.');
            } else {
                // Log the error and return to the reset password form with an error message
                $errorMessage = $response->json()['message'] ?? 'An error occurred.';
                return back()->withErrors(['error' => 'Error: ' . $errorMessage])->withInput();
            }
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Reset Password API Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return to the reset password form with an error message
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again later.'])->withInput();
        }
    }
}
