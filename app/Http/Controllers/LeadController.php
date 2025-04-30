<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Leads/all-leads';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        $pageNumber = request()->query('pageNumber', 1);
        $pageSize = request()->query('pageSize', 100);

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($apiUrl, [
                'pageNumber' => $pageNumber,
                'pageSize' => $pageSize,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $leads = $data['items'] ?? [];
                $leadCount = $data['totalRecords'] ?? 0;
                $totalPages = $data['totalPages'] ?? 1;

                return view('Lead.lead', compact('leads', 'leadCount', 'pageNumber', 'totalPages'));
            } else {
                return view('Lead.lead', ['leads' => [], 'leadCount' => 0, 'pageNumber' => 1, 'totalPages' => 1])
                    ->withErrors(['error' => 'Failed to fetch leads.']);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching leads:', ['error' => $e->getMessage()]);
            return view('Lead.lead', ['leads' => [], 'leadCount' => 0, 'pageNumber' => 1, 'totalPages' => 1])
                ->withErrors(['error' => 'An error occurred while fetching leads.']);
        }
    }

    public function show($id)
    {
        $apiUrl = "http://192.168.1.9:2030/api/Leads/lead-info/{$id}";
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            if ($response->successful()) {
                $lead = $response->json()[0] ?? null;

                if (!$lead) {
                    return back()->withErrors(['error' => 'Lead not found.']);
                }

                // Ensure the 'deals' array contains the 'dealStatus' field
                $lead['deals'] = $lead['deals'] ?? [
                    'dealName' => '',
                    'assignedSalesRep' => '',
                    'dealValue' => '',
                    'currency' => '',
                    'stage' => '',
                    'dealStatus' => '', // Add default value for dealStatus
                ];

                return view('Lead.leads-details', ['lead' => $lead]);
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to fetch lead details.';
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching lead details:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }

    public function editLead($id)
    {
        $apiUrl = "http://192.168.1.9:2030/api/Leads/lead-info/{$id}";
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => 'application/json',
            ])->get($apiUrl);

            if ($response->successful()) {
                $lead = $response->json()[0] ?? null;

                if (!$lead) {
                    return back()->withErrors(['error' => 'Lead not found.']);
                }

                // Pass the 'editMode' flag to the view
                return view('Lead.leads-details', ['lead' => $lead, 'editMode' => true]);
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to fetch lead details.';
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred.']);
        }
    }

    public function updateLead(Request $request, $id)
    {
        $apiUrl = "http://192.168.1.9:2030/api/Leads/update-lead/{$id}";
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        // Validation rules for nullable fields
        $request->validate([
            'leadSource' => 'nullable|string',
            'status' => 'nullable|string',
            'dealName' => 'nullable|string',
            'dealValue' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'stage' => 'nullable|string',
            'assignedSalesRep' => 'nullable|string',
            'dealStatus' => 'nullable|string',
            'estimatedValue' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'paymentTerms' => 'nullable|string',
            'invoiceNumber' => 'nullable|string',
            'paymentStatus' => 'nullable|string',
        ]);

        try {
            // Prepare the data payload
            $data = $request->only([
                'leadSource', 'status', 'dealName', 'dealValue', 'currency', 'stage',
                'assignedSalesRep', 'dealStatus', 'estimatedValue', 'discount',
                'paymentTerms', 'invoiceNumber', 'paymentStatus'
            ]);

            // Log the values of status and dealStatus for debugging
            Log::info('Status Field:', ['status' => $data['status'] ?? 'Not Provided']);
            Log::info('Deal Status Field:', ['dealStatus' => $data['dealStatus'] ?? 'Not Provided']);

            // Log the entire payload for debugging
            Log::info('Update Lead Payload:', $data);

            $response = Http::withHeaders([
                'Authorization' => $token,
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
            ])->put($apiUrl, $data);

            // Log the API response
            Log::info('API Response:', ['status' => $response->status(), 'body' => $response->body()]);

            if ($response->successful()) {
                return redirect()->route('leads.details', $id)->with('success', 'Lead updated successfully.');
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to update lead.';
                return back()->withErrors(['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            Log::error('Error updating lead:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Leads/add-leads';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        $request->validate([
            'leadSource' => 'nullable|string',
            'status' => 'nullable|string',
            'clientID' => 'nullable|integer',
            // Lead Management
            'fullName' => 'required|string',
            'email' => 'required|email',
            'phoneNumber' => 'required|string',
            'companyName' => 'nullable|string',
            'industry' => 'nullable|string',
            // Deal Management
            'dealName' => 'nullable|string',
            'dealValue' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'stage' => 'nullable|string',
            'assignedSalesRep' => 'nullable|string',
            'dealStatus' => 'nullable|string',
            'notes' => 'nullable|string',
            // Payment
            'estimatedValue' => 'nullable|numeric',
            'discounts' => 'nullable|numeric',
            'paymentTerms' => 'nullable|string',
            'invoiceNumber' => 'nullable|string',
            'paymentStatus' => 'nullable|string',
        ]);

        // Build the payload for the API
        $payload = [
            'leadSource' => $request->input('leadSource'),
            'status' => $request->input('status'),
            'clientID' => $request->input('clientID', 0),
            'fullName' => $request->input('fullName'),
            'email' => $request->input('email'),
            'phoneNumber' => $request->input('phoneNumber'),
            'companyName' => $request->input('companyName'),
            // Fix: If industry is "N/A", send as empty string
            'industry' => ($request->input('industry') === 'N/A') ? '' : $request->input('industry'),
            'deals' => [
                'dealName' => $request->input('dealName'),
                'dealValue' => $request->input('dealValue', 0),
                'currency' => $request->input('currency'),
                'stage' => $request->input('stage'),
                'assignedSalesRep' => $request->input('assignedSalesRep'),
                'status' => $request->input('dealStatus'),
                'notes' => $request->input('notes'),
            ],
            'payment' => [
                'estimatedValue' => $request->input('estimatedValue', 0),
                // Fix: Map discounts to discount
                'discount' => $request->input('discounts', 0),
                'paymentTerms' => $request->input('paymentTerms'),
                'invoiceNumber' => $request->input('invoiceNumber'),
                'paymentStatus' => $request->input('paymentStatus'),
            ],
        ];

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => $token,
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, $payload);

            if ($response->successful()) {
                return redirect()->route('leads.index')->with('success', 'Lead added successfully.');
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to add lead.';
                return back()->withErrors(['error' => $errorMessage])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()])->withInput();
        }
    }
}
