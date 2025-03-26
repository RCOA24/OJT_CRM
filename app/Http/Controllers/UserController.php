<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->query('search', '');
    
        $response = Http::withHeaders([
            'Authorization' => '1234',
            'Accept' => 'application/json',
        ])->get('http://192.168.1.9:2030/api/Users/all-users');
    
        $users = $response->successful() ? $response->json() : [];  
    
        // Filter users based on search query
        if (!empty($searchQuery)) {
            $users = array_filter($users, function ($user) use ($searchQuery) {
                return stripos($user['userName'], $searchQuery) !== false;
            });
        }
    
        if ($request->ajax()) {
            return response()->json([
                'html' => view('auth.partials.users-table', compact('users'))->render()
            ]);
        }
    
        return view('auth.users', compact('users'));
    }

    public function getUser($id)
    {
        $response = Http::withHeaders([
            'Authorization' => '1234',
            'Accept' => 'application/json',
        ])->get("http://192.168.1.9:2030/api/Users/{$id}");
    
        if ($response->successful()) {
            return response()->json($response->json());
        }
    
        return response()->json(['error' => 'User not found'], 404);
    }
    
    public function updateUser(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'middleName' => 'nullable|string',
            'lastName' => 'required|string',
            'phoneNumber' => 'required|string',
            'userName' => 'required|string',
            'email' => 'required|email'
        ]);

        $response = Http::withHeaders([
            'Authorization' => '1234',
            'Accept' => 'application/json',
        ])->put("http://192.168.1.9:2030/api/Users/update/{$id}", $validatedData);

        if ($response->successful()) {
            return response()->json(['message' => 'User updated successfully!']);
        }

        return response()->json(['error' => 'Failed to update user.', 'details' => $response->json()], 400);
    }
    
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'middleName' => 'nullable|string',
            'lastName' => 'required|string',
            'phoneNumber' => 'required|string',
            'userName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'confirmPassword' => 'required|string|same:password',
            'status' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Authorization' => '1234',
            'Accept' => 'application/json',
        ])->post('http://192.168.1.9:2030/api/Users/register', $validatedData);

        if ($response->successful()) {
            return response()->json(['message' => 'User registered successfully!'], 201);
        }

        return response()->json(['error' => 'Failed to register user.', 'details' => $response->json()], 400);
    }
}
