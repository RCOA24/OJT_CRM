<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        return view('auth.dashboard');
    }

    public function getCounts()
    {
        try {
            // Fetch total clients
            $clientsResponse = Http::withHeaders([
                'Authorization' => '1234',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache', // Ensure fresh data
                'Pragma' => 'no-cache',
            ])->get('http://192.168.1.9:2030/api/Clients/all-clients');

            // Fetch total users
            $usersResponse = Http::withHeaders([
                'Authorization' => '1234',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache', // Ensure fresh data
                'Pragma' => 'no-cache',
            ])->get('http://192.168.1.9:2030/api/Users/all-users');

            // Extract total clients from the "totalRecords" field
            $totalClients = $clientsResponse->successful() && isset($clientsResponse->json()['totalRecords']) 
                ? $clientsResponse->json()['totalRecords'] 
                : 0;

            // Count total users from the array
            $totalUsers = $usersResponse->successful() && is_array($usersResponse->json()) 
                ? count($usersResponse->json()) 
                : 0;

            return response()->json([
                'totalClients' => $totalClients,
                'totalUsers' => $totalUsers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch counts',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
