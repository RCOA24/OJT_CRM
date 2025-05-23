<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function fetchClients(Request $request)
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Clients/all-clients';
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            // Extract query parameters for sorting and filtering
            $queryParams = [
                'ascending' => $request->query('ascending', 'true'), // Default to ascending
                'sortByRecentlyAdded' => $request->query('sortByRecentlyAdded', 'false'), // Default to not recently added
                'pageNumber' => $request->query('pageNumber', 1),
                'pageSize' => $request->query('pageSize', 10),
                'isArchived' => 'false', // Ensure only non-archived clients are fetched
                'industryType' => $request->query('industryType', ''), // Filter by industry type
                'leadSource' => $request->query('leadSource', ''), // Filter by lead source
            ];

            // Log the query parameters for debugging
            Log::info('Fetching clients with query parameters', $queryParams);

            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->get($apiUrl, $queryParams);

            if ($response->successful()) {
                return response()->json($response->json('items') ?? []);
            } else {
                Log::error('Failed to fetch clients', ['response' => $response->body()]);
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching clients:', ['error' => $e->getMessage()]);
            return response()->json([], 500);
        }
    }

    // public function searchClients(Request $request)
    // {
    //     $allClientsApiUrl = 'http://192.168.1.9:2030/api/Clients/all-clients';
    //     $searchApiUrl = 'http://192.168.1.9:2030/api/Clients/search-client';
    //     $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

    //     try {
    //         $query = $request->query('query', '');
    //         $pageNumber = $request->query('pageNumber', 1);
    //         $pageSize = $request->query('pageSize', 10);

    //         // If the query is empty, fetch all clients with pagination
    //         if (empty($query)) {
    //             $response = Http::withHeaders([
    //                 'Authorization' => $authorization,
    //                 'Accept' => 'application/json',
    //             ])->get($allClientsApiUrl, [
    //                 'pageNumber' => $pageNumber,
    //                 'pageSize' => $pageSize,
    //             ]);

    //             if ($response->successful()) {
    //                 $clients = $response->json('items') ?? [];
    //                 return response()->json(['clients' => $clients]);
    //             } else {
    //                 Log::error('Failed to fetch all clients', ['status' => $response->status(), 'body' => $response->body()]);
    //                 return response()->json(['clients' => []], 500);
    //             }
    //         }

    //         // If a query is provided, perform a search
    //         $response = Http::withHeaders([
    //             'Authorization' => $authorization,
    //             'Accept' => 'application/json',
    //         ])->get($searchApiUrl, ['query' => $query]);

    //         if ($response->successful()) {
    //             $clients = $response->json('items') ?? [];
    //             return response()->json(['clients' => $clients]);
    //         } else {
    //             Log::error('Failed to search clients', ['status' => $response->status(), 'body' => $response->body()]);
    //             return response()->json(['clients' => []], 500);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error searching clients:', ['error' => $e->getMessage()]);
    //         return response()->json(['clients' => []], 500);
    //     }
    // }

    public function archiveClient(Request $request)
    {
        $archiveUrl = 'http://192.168.1.9:2030/api/Clients/is-archived-client';
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';
        
        try {
            $clientId = $request->input('clientId');

            // Log the request data for debugging
            Log::info('Archiving client', ['clientId' => $clientId]);

            // Ensure the clientId is being sent correctly
            if (empty($clientId)) {
                Log::error('Client ID is missing or invalid.');
                return redirect()->route('clients.list')->withErrors(['error' => 'Client ID is missing or invalid.']);
            }
            
            // Send the request with query parameters
            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->put("$archiveUrl?isArchived=true&clientId=$clientId");

            // Log the API response for debugging
            Log::info('Archive client response', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful() && $response->body() !== '"Client not found"') {
                return redirect()->route('clients.list')->with('success', 'Client archived successfully.');
            } else {
                Log::error('Failed to archive client', ['response' => $response->body()]);
                return redirect()->route('clients.list')->withErrors(['error' => 'Failed to archive client.']);
            }
        } catch (\Exception $e) {
            Log::error('Error archiving client:', ['error' => $e->getMessage()]);
            return redirect()->route('clients.list')->withErrors(['error' => 'An error occurred while archiving the client.']);
        }
    }

    public function filterClients(Request $request)
    {
        $allClients = $this->fetchClients($request)->getData();
        $industry = $request->query('industry', '');
        $leadSource = $request->query('leadSource', '');

        $filteredClients = array_filter($allClients, function ($client) use ($industry, $leadSource) {
            $industryMatch = $industry ? ($client['companyDetails']['industryType'] ?? '') === $industry : true;
            $leadSourceMatch = $leadSource ? ($client['clientDetails']['leadSources'] ?? '') === $leadSource : true;
            return $industryMatch && $leadSourceMatch;
        });

        return response()->json(array_values($filteredClients));
    }

    public function index(Request $request)
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Clients/all-clients';
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $queryParams = [
                'pageNumber' => 1,
                'pageSize' => 10,
                'ascending' => 'true', // Ensure this is a string
                'sortByRecentlyAdded' => 'false', // Ensure this is a string
            ];

            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->get($apiUrl, $queryParams);

            if ($response->successful()) {
                $clients = $response->json('items') ?? []; // Extract the "items" array from the API response
                Log::info('Clients fetched successfully', ['clients' => $clients]); // Debugging log
            } else {
                $clients = []; // Default to an empty array if the response is not successful
                Log::error('Failed to fetch clients', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            $clients = []; // Default to an empty array in case of an exception
            Log::error('Error fetching clients:', ['error' => $e->getMessage()]);
        }

        return view('clients.list', compact('clients'));
    }

    public function archive()
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Clients/all-archive-clients'; // Fixed typo
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            if ($response->successful()) {
                $archivedClients = $response->json() ?? [];
            } else {
                Log::error('Failed to fetch archived clients', ['response' => $response->body()]);
                $archivedClients = [];
            }
        } catch (\Exception $e) {
            Log::error('Error fetching archived clients:', ['error' => $e->getMessage()]);
            $archivedClients = [];
        }

        return view('clients.archive', compact('archivedClients'));
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

                // Only reconstruct if missing (for backward compatibility)
                if (!isset($client['contactPerson']) || !is_array($client['contactPerson'])) {
                    $client['contactPerson'] = [[
                        'contactName' => $client['contactName'] ?? '',
                        'jobTitle' => $client['jobTitle'] ?? '',
                        'department' => $client['department'] ?? '',
                        'directEmail' => $client['directEmail'] ?? '',
                        'directPhone' => $client['directPhoneNumber'] ?? '',
                    ]];
                }
                if (!isset($client['companyDetails']) || !is_array($client['companyDetails'])) {
                    $client['companyDetails'] = [
                        'companyName' => $client['companyName'] ?? '',
                        'industryType' => $client['industryType'] ?? '',
                        'businessRegNumber' => $client['businessRegNumber'] ?? '',
                        'companySize' => $client['companySize'] ?? '',
                        'companyAddress' => $client['companyAddress'] ?? '',
                    ];
                }
                if (!isset($client['clientDetails']) || !is_array($client['clientDetails'])) {
                    $client['clientDetails'] = [
                        'leadSources' => $client['leadSources'] ?? '',
                        'clientType' => $client['clientType'] ?? '',
                        'notes' => $client['notes'] ?? [],
                    ];
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

    public function fetchArchivedClients()
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Clients/all-archive-clients'; // Fixed typo
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            if ($response->successful()) {
                return $response->json() ?? [];
            } else {
                Log::error('Failed to fetch archived clients', ['response' => $response->body()]);
                return [];
            }
        } catch (\Exception $e) {
            Log::error('Error fetching archived clients:', ['error' => $e->getMessage()]);
            return [];
        }
    }

    public function unarchiveClient(Request $request)
    {
        $unarchiveUrl = 'http://192.168.1.9:2030/api/Clients/is-archived-client';
        $authorization = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $clientId = $request->input('clientId');

            // Log the request data for debugging
            Log::info('Unarchiving client', ['clientId' => $clientId]);

            if (empty($clientId)) {
                return redirect()->route('clients.archive')->withErrors(['error' => 'Client ID is missing or invalid.']);
            }

            $response = Http::withHeaders([
                'Authorization' => $authorization,
                'Accept' => 'application/json',
            ])->put("$unarchiveUrl?isArchived=false&clientId=$clientId");

            if ($response->successful()) {
                return redirect()->route('clients.archive')->with('success', 'Client unarchived successfully.');
            } else {
                Log::error('Failed to unarchive client', ['response' => $response->body()]);
                return redirect()->route('clients.archive')->withErrors(['error' => 'Failed to unarchive client.']);
            }
        } catch (\Exception $e) {
            Log::error('Error unarchiving client:', ['error' => $e->getMessage()]);
            return redirect()->route('clients.archive')->withErrors(['error' => 'An error occurred while unarchiving the client.']);
        }
    }

    public function editClient($id)
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

                // Reconstruct nested arrays for view compatibility
                $client['contactPerson'] = [[
                    'contactName' => $client['contactName'] ?? '',
                    'jobTitle' => $client['jobTitle'] ?? '',
                    'department' => $client['department'] ?? '',
                    'directEmail' => $client['directEmail'] ?? '',
                    'directPhone' => $client['directPhoneNumber'] ?? '',
                ]];
                $client['companyDetails'] = [
                    'companyName' => $client['companyName'] ?? '',
                    'industryType' => $client['industryType'] ?? '',
                    'businessRegNumber' => $client['businessRegNumber'] ?? '',
                    'companySize' => $client['companySize'] ?? '',
                    'companyAddress' => $client['companyAddress'] ?? '',
                ];

                // Pass the 'editMode' flag to the view
                return view('clients.client-details', ['client' => $client, 'editMode' => true]);
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to fetch client details.';
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }

    public function updateClient(Request $request, $id)
    {
        $apiUrl = "http://192.168.1.9:2030/api/Clients/update-client/{$id}";
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        // Validate the request
        $request->validate([
            'phoneNumber' => ['required', 'regex:/^09\d{9}$/', 'size:11'],
            'companyAddress' => [
                'required',
                'string',
                'regex:/^([^,]*,){3}[^,]*$/',
            ],
        ], [
            'phoneNumber.regex' => 'The mobile number must start with 09 and be 11 digits long.',
            'companyAddress.regex' => 'The address must include a ZIP code, city, province, and country.',
        ]);

        try {
            $data = [
                'photoLink' => $request->input('photoLink', 'string'),
                'fullName' => $request->input('fullName', 'string'),
                'phoneNumber' => $request->input('phoneNumber', '09562525094'),
                'email' => $request->input('email', 'example@example.com'),
                'websiteURL' => $request->input('websiteURL', 'string'),
                'contactName' => $request->input('contactName', 'string'),
                'jobTitle' => $request->input('jobTitle', 'string'),
                'department' => $request->input('department', 'string'),
                'directEmail' => $request->input('directEmail', 'example@example.com'),
                'directPhoneNumber' => $request->input('directPhoneNumber', '09535251311'),
                'companyName' => $request->input('companyName', 'string'),
                'industryType' => $request->input('industryType', 'string'),
                'businessRegNumber' => $request->input('businessRegNumber', 'string'),
                'companySize' => $request->input('companySize', 'string'),
                'companyAddress' => $request->input('companyAddress', 'string'),
            ];

            // Log the payload
            Log::info('Update Client Payload:', $data);

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
            ])->put($apiUrl, $data);

            // Log the API response
            Log::info('API Response:', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                return redirect()->route('clients.show', $id)->with('success', 'Client updated successfully.');
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to update client.';
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating client:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    public function addNoteToClient(Request $request, $id)
    {
        $apiUrl = "http://192.168.1.9:2030/api/Clients/add-notes-to-client/{$id}";
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        $request->validate([
            'noteContent' => 'required|string|max:1000',
        ], [
            'noteContent.required' => 'The note content is required.',
            'noteContent.max' => 'The note content must not exceed 1000 characters.',
        ]);

        try {
            $noteContent = $request->input('noteContent');

            // Log the API URL and payload for debugging
            Log::info('Adding note to client', [
                'url' => $apiUrl,
                'payload' => $noteContent,
            ]);

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'content' => $noteContent,
            ]);

            // Log the API response for debugging
            Log::info('API Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->status() === 201 || $response->status() === 200) {
                return redirect()->route('clients.show', $id)->with('success', 'Note added successfully.');
            } else {
                Log::error('Failed to add note to client', ['response' => $response->body()]);
                return back()->withErrors(['error' => 'Failed to add note to the client.']);
            }
        } catch (\Exception $e) {
            Log::error('Error adding note to client:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An error occurred while adding the note.']);
        }
    }
}
