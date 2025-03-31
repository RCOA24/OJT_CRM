<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /**
     * Display the reset password form.
     */
    public function create(string $token): View
    {
        dd($token);
        return view('auth.reset-password', ['token' => $token]);
    }
    

    /**
     * Handle the reset password request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $payload = [
                'token' => $request->token,
                'email' => strtolower($request->email),
                'newPassword' => $request->password,
                'confirmPassword' => $request->password_confirmation,
            ];

            Log::info('Reset Password API Request Payload', $payload);

            $response = Http::withHeaders([
                'Authorization' => '1234',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('http://192.168.1.9:2030/api/Auth/reset-password', $payload);

            Log::info('Reset Password API Response', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $message = $responseData['message'] ?? 'Password reset successfully.';

                Log::info('Password reset successful', ['message' => $message]);
                return redirect()->route('login')->with('success', $message);
            }

            $errorMessage = $response->json()['message'] ?? 'Failed to reset password.';
            Log::error('Password reset failed', [
                'status' => $response->status(),
                'error' => $errorMessage,
            ]);

            return back()->withErrors(['email' => $errorMessage]);
        } catch (\Exception $e) {
            Log::error('Reset Password Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}