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
                'Authorization' => 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P', // Use Authorization header
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'photoLink' => $photoLink, // Use the URL of the uploaded photo
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
                    'leadSources' => $request->input('leadSources') ?? 'N/A', // Default to 'N/A' if not provided
                    'clientType' => $request->input('clientType') ?? 'N/A',   // Default to 'N/A' if not provided
                    'notes' => $request->input('notes') ? [$request->input('notes')] : [], // Ensure notes is an array
                ],
            ]);

            // Log the full payload for debugging
            Log::info('Final Payload Sent to API:', [
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

            Log::info('Add Client API Response:', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ]);

            if (!$response->successful()) {
                Log::error('Add Client API Error Details:', [
                    'status' => $response->status(),
                    'headers' => $response->headers(),
                    'body' => $response->body(),
                ]);

                // Fallback error message if the API does not provide details
                $errorMessage = $response->json('message') ?? 'The server encountered an error. Please contact support.';
                return back()->withErrors(['error' => $errorMessage]);
            }

            if ($response->successful()) {
                $responseBody = $response->json();

                // Check if the response contains 'items' and handle accordingly
                if (isset($responseBody['items']) && is_array($responseBody['items']) && count($responseBody['items']) > 0) {
                    $clientData = $responseBody['items'][0]; // Extract the first item if 'items' exists
                    return redirect()->route('clients.list')->with([
                        'success' => 'Client added successfully.',
                        'client' => $clientData,
                        'redirectWithTimer' => true, // Add this flag for the timer
                    ]);
                }

                // If 'items' is not present, fallback to a success message
                return redirect()->route('clients.list')->with([
                    'success' => 'Client added successfully.',
                    'redirectWithTimer' => true, // Add this flag for the timer
                ]);
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to add client. Please try again.';
                Log::error('Add Client API Error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'message' => $errorMessage,
                ]);
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            Log::error('Add Client Exception:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }
}
