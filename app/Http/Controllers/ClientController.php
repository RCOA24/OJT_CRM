<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.list');
    }

    public function archive()
    {
        // Fetch archived clients from the database or API
        // Example: Replace this with your actual logic
        $archivedClients = []; // Replace with actual data fetching logic

        return view('clients.archive', ['archivedClients' => $archivedClients]);
    }
}
