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
                'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache', // Ensure fresh data
                'Pragma' => 'no-cache',
            ])->get('http://192.168.1.9:2030/api/Clients/all-clients');

            // Fetch total users
            $usersResponse = Http::withHeaders([
                'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache', // Ensure fresh data
                'Pragma' => 'no-cache',
            ])->get('http://192.168.1.9:2030/api/Users/all-users');

            // Fetch pending tasks
            $pendingTasksResponse = Http::withHeaders([
                'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache',
                'Pragma' => 'no-cache',
            ])->get('http://192.168.1.9:2030/api/Task/all-tasks?Status=Pending&pageNumber=1&pageSize=10');

            // Extract total clients from the "totalRecords" field
            $totalClients = $clientsResponse->successful() && isset($clientsResponse->json()['totalRecords']) 
                ? $clientsResponse->json()['totalRecords'] 
                : 0;

            // Count total users from the array
            $totalUsers = $usersResponse->successful() && is_array($usersResponse->json()) 
                ? count($usersResponse->json()) 
                : 0;

            // Extract total pending tasks from the "totalRecords" field
            $totalPendingTasks = $pendingTasksResponse->successful() && isset($pendingTasksResponse->json()['totalRecords']) 
                ? $pendingTasksResponse->json()['totalRecords'] 
                : 0;

            return response()->json([
                'totalClients' => $totalClients,
                'totalUsers' => $totalUsers,
                'totalPendingTasks' => $totalPendingTasks,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch counts',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
