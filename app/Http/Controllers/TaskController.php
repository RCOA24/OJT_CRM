<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TaskController extends Controller
{
    public function index()
    {
        // Define the API URL and token
        $apiUrl = 'http://192.168.1.9:2030/api/Task/all-tasks?pageNumber=1&pageSize=10';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        // Send the API request with the correct headers
        $response = Http::withHeaders([
            'Authorization' => $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->get($apiUrl);

        // Check if the API request was successful
        if ($response->successful()) {
            $tasks = $response->json()['items']; // Extract the 'items' array
            $taskCount = count($tasks); // Count the tasks
        } else {
            $tasks = []; // Fallback to an empty array if the API call fails
            $taskCount = 0; // Default task count
        }

        return view('task.index', compact('tasks', 'taskCount'));
    }
}
