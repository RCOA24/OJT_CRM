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
     *
     * @param string $token Base64-encoded token containing the email
     * @return View The reset password view
     */
    public function create(string $token): View
    {
        // Decode the Base64-encoded token into the email
        $email = base64_decode($token);

        // Log the decoded email for debugging
        Log::info('Decoded Reset Password Token', ['token' => $token, 'email' => $email]);
       
        // Ensure the decoded email is valid
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Log::error('Reset Password: Invalid Base64 token or email');
            abort(400, 'Invalid reset token.');
        }

        // Pass the original token and decoded email to the view
        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Handle an incoming new password request.
     *
     * @param Request $request The HTTP request containing the reset password data
     * @return RedirectResponse Redirects to the login page or back with errors
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request data
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        try {
            // Prepare the payload to match the API's expected schema
            $payload = [
                'email' => $request->email,
                'newPassword' => $request->password,
                'confirmPassword' => $request->password_confirmation,
            ];

            // Log the payload for debugging
            Log::info('Reset Password Request Payload', $payload);

            // Send the request to the API with a timeout
            $resetResponse = Http::withHeaders([
                'Authorization' => '1234', // Ensure this token is valid
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->timeout(10) // Set a timeout of 10 seconds
              ->post('http://192.168.1.9:2030/api/Auth/reset-password', $payload);

            // Log the API response for debugging
            Log::info('Reset Password API Response', [
                'status' => $resetResponse->status(),
                'headers' => $resetResponse->headers(),
                'body' => $resetResponse->body(),
                'json' => $resetResponse->json() ?? null,
            ]);

            // Handle the API response
            if ($resetResponse->successful()) {
                // Log success and redirect to the login page
                Log::info('Password reset confirmed by API', [
                    'email' => $request->email,
                ]);

                // Redirect with a flash message
                return redirect()->route('login')->with('success', 'Your password has been reset successfully.');
            } else {
                // Log the error and return with validation errors
                $errorMessage = $resetResponse->json()['message'] ?? 'An error occurred while resetting your password.';
                Log::error('Reset Password Failed', [
                    'status' => $resetResponse->status(),
                    'error' => $errorMessage,
                    'response_body' => $resetResponse->body(),
                ]);
                return back()->withErrors(['email' => $errorMessage]);
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Log request-specific exceptions
            Log::error('Password Reset Request Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['email' => 'Unable to connect to the server. Please try again later.']);
        } catch (\Exception $e) {
            // Log general exceptions
            Log::error('Password Reset Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }
}
