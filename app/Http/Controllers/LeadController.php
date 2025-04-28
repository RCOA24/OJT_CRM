<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function index()
    {
        $apiUrl = 'http://192.168.1.9:2030/api/Leads/all-leads';
        $token = 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P';

        $pageNumber = request()->query('pageNumber', 1);
        $pageSize = request()->query('pageSize', 10);

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
}
