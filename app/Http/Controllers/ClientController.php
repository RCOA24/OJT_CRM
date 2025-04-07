<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $clients = Http::withHeaders([
            'Authorization' => '1234',
            'Accept' => 'application/json',
        ])->get('http://192.168.1.9:2030/api/Clients/all-clients', [
            'search' => $search,
        ]);

        return view('clients.list', ['clients' => $clients->json()]);
    }

    public function archive()
    {
        // Fetch archived clients from the database or API
        // Example: Replace this with your actual logic
        $archivedClients = []; // Replace with actual data fetching logic

        return view('clients.archive', ['archivedClients' => $archivedClients]);
    }
}
