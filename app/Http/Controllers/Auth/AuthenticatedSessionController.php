<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

  public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'password' => 'required',
    ]);

    // Fetch API URL from .env
    $apiUrl = env('API_AUTH_URL', 'http://192.168.1.9:2030/api/Auth/login');

    // Send request to API with Authorization header
    $response = Http::withHeaders([
        'Authorization' => '1234',
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->post($apiUrl, [
        'userName' => $request->username,
        'passWord' => $request->password,
        'rememberMe' => true,
    ]);

    // Check if authentication was successful
    if ($response->successful()) {
        $data = $response->json();

        // Store token in session
        session(['api_token' => $data['token']]);

        // Flash success message
        return redirect()->route('dashboard')->with('success', 'Login successful!');
    }

    // Flash error message
    return back()->with('error', 'Invalid username or password. Please try again.');
}


public function register(Request $request)
{
    // Validate the input fields
    $validatedData = $request->validate([
        'last_name' => 'required|string',
        'first_name' => 'required|string',
        'middle_name' => 'nullable|string',
        'phone_number' => 'required|string',
        'username' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    // API URL
    $apiUrl = env('API_AUTH_URL', 'http://192.168.1.9:2030/api/Users/register');

    try {
        // Send request to external API
        $response = Http::withHeaders([
            'Authorization' => '1234',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($apiUrl, [
            'lastName' => $validatedData['last_name'],
            'firstName' => $validatedData['first_name'],
            'middleName' => $validatedData['middle_name'],
            'phoneNumber' => $validatedData['phone_number'],
            'userName' => $validatedData['username'],
            'email' => $validatedData['email'],
            'passWord' => $validatedData['password'],
        ]);

        // If registration is successful
        if ($response->successful()) {
            return redirect()->back()->with('success', 'User registered successfully!');
        }

        // If the API returns validation errors
        if ($response->status() === 400) {
            $errorData = $response->json();
            $errorMessage = isset($errorData['message']) ? $errorData['message'] : 'Invalid request data.';
            return redirect()->back()->with('error', $errorMessage);
        }

        // If unauthorized (wrong API key or authentication issue)
        if ($response->status() === 401) {
            return redirect()->back()->with('error', 'Unauthorized request. Please check your credentials.');
        }

        // If the API is not found
        if ($response->status() === 404) {
            return redirect()->back()->with('error', 'API endpoint not found. Please check the URL.');
        }

        // Handle other possible errors
        return redirect()->back()->with('error', 'Registration failed. Please try again.');
    
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
    }
}

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // public function forgotPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     try {
    //         $response = Http::withHeaders([
    //             'Authorization' => '1234',
    //             'Accept' => 'application/json',
    //         ])->post('http://192.168.1.9:2030/api/Auth/forgot-password', [
    //             'email' => $request->email,
    //         ]);

    //         if ($response->successful()) {
    //             return redirect()->route('forgotpassword')->with('success', 'A reset link has been sent to your email.');
    //         } else {
    //             return redirect()->route('forgotpassword')->with('error', 'Failed to send reset link. Please try again.');
    //         }
    //     } catch (\Exception $e) {
    //         return redirect()->route('forgotpassword')->with('error', 'An error occurred. Please try again.');
    //     }
    // }
}
