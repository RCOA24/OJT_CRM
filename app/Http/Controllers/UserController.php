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
        $page = (int)$request->query('page', 1);
        $perPage = 5;

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
            $users = array_values($users); // Reset array keys after filtering
        }

        // Ensure strict pagination
        $totalUsers = count($users);
        $offset = ($page - 1) * $perPage;
        $users = array_slice($users, $offset, $perPage, true);

        $pagination = [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $totalUsers,
            'last_page' => ceil($totalUsers / $perPage),
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('auth.partials.users-table', compact('users', 'pagination'))->render()
            ]);
        }

        return view('auth.users', compact('users', 'pagination'));
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
        $response = Http::withHeaders([
            'Authorization' => '1234',
            'Accept' => 'application/json',
        ])->put("http://192.168.1.9:2030/api/Users/update/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->back()->with('success', 'User Updated Successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update user.');
    }
        

}