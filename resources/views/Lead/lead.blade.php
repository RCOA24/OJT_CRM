@extends('layouts.app')

@section('title', 'Leads')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 sm:p-6 bg-[#F9FAFB] pt-20">
    <div class="container mx-auto bg-white shadow-md rounded-xl p-4 sm:p-8">
        <!-- Flash Message -->
        @if (session('success'))
            <div id="flash-message" class="mb-4 p-4 rounded-lg text-white bg-green-500 shadow-lg animate-slide-in">
                <div class="flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button id="close-flash" class="text-white hover:text-gray-200 focus:outline-none">
                        <x-cancelicon class="w-5 h-5" />
                    </button>
                </div>
            </div>
        @endif
      
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 space-y-4 md:space-y-0">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-semibold text-gray-800">
                Leads <span id="lead-count" class="text-sm text-gray-500">({{ $leadCount ?? 0 }} leads)</span>
            </h1>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 w-full md:w-auto">
                <!-- Search Bar -->
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <x-searchtask class="w-5 h-5 text-gray-400" />
                    </span>
                    <input type="text" id="search-input" placeholder="Search leads..." 
                           class="border border-gray-300 rounded-md pl-12 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#205375] 
                                  placeholder-gray-400 text-gray-700 w-full shadow-sm" autocomplete="on">
                </div>
               
                <button onclick="window.location.href='{{ route('leads.add-modal') }}'" 
                        class="bg-[#205375] text-white px-4 md:px-6 py-3 rounded-md hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-addicon class="w-5 h-5 mr-2" /> Add New Lead
                </button>
            </div>
        </div>

        <!-- Leads Table -->
        <div class="overflow-x-auto overflow-y-auto max-h-96">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-[#205375] border-b sticky top-0 z-5">
                    <tr class="text-left text-sm md:text-base font-medium text-white">
                        <th class="py-3 md:py-4 px-4 md:px-6"><input type="checkbox"></th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Full Name</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Email</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Phone Number</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Company Name</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Industry</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Deal Name</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Stage</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Assigned Sales</th>
                        <th class="py-3 md:py-4 px-4 md:px-6">Create Date</th>
                    </tr>
                </thead>
                <tbody id="lead-table-body">
                    @forelse ($leads as $lead)
                        <tr class="text-sm md:text-base text-[#444444] hover:bg-gray-200 transition duration-200 ease-in-out">
                            <td class="py-3 md:py-4 px-4 md:px-6"><input type="checkbox"></td>
                            <td class="py-3 md:py-4 px-4 md:px-6">
                                <a href="{{ route('leads.details', ['id' => $lead['leadId'] ?? '']) }}" class="text-blue-500 hover:underline">
                                    {{ $lead['fullName'] ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $lead['email'] ?? 'N/A' }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $lead['phoneNumber'] ?? 'N/A' }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $lead['companyName'] ?? 'N/A' }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $lead['industry'] ?? 'N/A' }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $lead['deals']['dealName'] ?? 'N/A' }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $lead['deals']['stage'] ?? 'N/A' }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ $lead['deals']['assignedSalesRep'] ?? 'N/A' }}</td>
                            <td class="py-3 md:py-4 px-4 md:px-6">{{ \Carbon\Carbon::parse($lead['dateCreated'] ?? now())->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-3 md:py-4 px-4 md:px-6 text-center text-gray-500">No leads available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
