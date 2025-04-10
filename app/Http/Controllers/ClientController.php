<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $clients = Http::withHeaders([
            'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
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

    public function addClient(Request $request)
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Clients/add-client';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            Log::info('Add Client Request Data:', ['data' => $request->all()]);

            $photoUpload = $request->file('photoUpload');
            $photoLink = null;

            if ($photoUpload) {
                // Save the uploaded file to a public directory and get its URL
                $photoPath = $photoUpload->store('uploads', 'public');
                $photoLink = asset('storage/' . $photoPath);

                // Log the generated photoLink for debugging
                Log::info('Generated photoLink:', ['photoLink' => $photoLink]);
            }

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'photoLink' => $photoLink,
                'firstName' => $request->input('firstName'),
                'middleName' => $request->input('middleName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'phoneNumber' => $request->input('mobileNumber'),
                'websiteUrl' => $request->input('websiteUrl'),
                'company' => [
                    'companyName' => $request->input('companyName'),
                    'industryType' => $request->input('industryType'),
                    'businessRegNumber' => $request->input('businessRegistrationNumber'),
                    'companySize' => $request->input('numberOfEmployees'),
                    'city' => $request->input('city'),
                    'stateProvince' => $request->input('stateProvince'),
                    'zipCode' => $request->input('zipCode'),
                    'country' => $request->input('country'),
                ],
                'contact' => [
                    [
                        'contactName' => $request->input('contactFullName'),
                        'jobTitle' => $request->input('jobTitle'),
                        'department' => $request->input('department'),
                        'directEmail' => $request->input('directEmail'),
                        'directPhoneNumber' => $request->input('directPhoneNumber'),
                    ]
                ],
                'details' => [
                    'leadSources' => $request->input('leadSources') ?? 'N/A',
                    'clientType' => $request->input('clientType') ?? 'N/A',
                    'notes' => $request->input('notes') ? [$request->input('notes')] : [],
                ],
            ]);

            if ($response->successful()) {
                return redirect()->route('clients.list')->with('success', 'Client added successfully.');
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to add client. Please try again.';
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            Log::error('Add Client Exception:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    public function showClient($id)
    {
        $apiUrl = "http://192.168.1.9:2030/api/Clients/client-info/{$id}";
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            if ($response->successful()) {
                $client = $response->json()[0] ?? null;

                if (!$client) {
                    return back()->withErrors(['error' => 'Client not found.']);
                }

                return view('clients.client-details', ['client' => $client]);
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to fetch client details.';
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }
}
