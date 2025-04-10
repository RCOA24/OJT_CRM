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
        $page = max(1, (int)$request->query('page', 1)); // Ensure page is at least 1
        $perPage = 5;
    
        // Fetch data from API with pagination and search
        $response = Http::withHeaders([
            'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
            'Accept' => 'application/json',
        ])->get('http://192.168.1.9:2030/api/Users/all-users', [
            'page' => $page,
            'per_page' => $perPage,
            'search' => $searchQuery
        ]);
    
        // Ensure API response is successful and contains data
        if ($response->successful() && isset($response['data'])) {
            // API supports pagination
            $users = $response['data'];
            $totalUsers = $response['total'] ?? 0;
            $lastPage = $response['last_page'] ?? max(1, ceil($totalUsers / $perPage));
        } else {
            // Fallback for API without pagination
            $users = $response->successful() ? $response->json() : [];
    
            // Apply search filtering manually
            if (!empty($searchQuery)) {
                $users = array_filter($users, function ($user) use ($searchQuery) {
                    return stripos($user['userName'], $searchQuery) !== false;
                });
                $users = array_values($users);
            }
    
            // Manual pagination
            $totalUsers = count($users);
            $lastPage = max(1, ceil($totalUsers / $perPage));
            $offset = ($page - 1) * $perPage;
            $users = array_slice($users, $offset, $perPage);
        }
    
        // Ensure requested page does not exceed last page
        if ($page > $lastPage) {
            return redirect()->route('users.index', ['page' => $lastPage]);
        }
    
        // Pagination metadata
        $pagination = [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $totalUsers,
            'last_page' => $lastPage,
        ];
    
        // Handle AJAX requests
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
            'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
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
            'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
            'Accept' => 'application/json',
        ])->put("http://192.168.1.9:2030/api/Users/update/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->back()->with('success', 'User Updated Successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update user.');
    }
        

}