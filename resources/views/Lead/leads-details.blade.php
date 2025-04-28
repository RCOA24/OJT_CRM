@extends('layouts.app')

@section('title', 'Lead Details')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 bg-gray-100">
    <div class="pt-20 container mx-auto bg-white shadow-lg rounded-xl p-8 max-w-[calc(100vw-2rem)] overflow-hidden">
        @if(session('success'))
            <div class="mb-6" id="flash-success">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative transition-opacity duration-700" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <button onclick="window.location.href='{{ route('leads.index') }}'" class="bg-[#205375] text-white p-3 mr-3 rounded-md hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-5 h-5" />
                </button>Lead Management
            </h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Lead Management Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Lead Management</h3>
                <div class="space-y-3">
                    <p><strong>Full Name:</strong> {{ $lead['fullName'] ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $lead['email'] ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $lead['phoneNumber'] ?? 'N/A' }}</p>
                    <p><strong>Company Name:</strong> {{ $lead['companyName'] ?? 'N/A' }}</p>
                    <p><strong>Industry:</strong> {{ $lead['industry'] ?? 'N/A' }}</p>
                    <p><strong>Lead Source:</strong> {{ $lead['leadSource'] ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ $lead['status'] ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Deal Management Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Deal Management</h3>
                <div class="space-y-3">
                    <p><strong>Currency:</strong> {{ $lead['deals']['currency'] ?? 'N/A' }}</p>
                    <p><strong>Deal Value:</strong> {{ $lead['deals']['dealValue'] ?? 'N/A' }}</p>
                    <p><strong>Deal Name:</strong> {{ $lead['deals']['dealName'] ?? 'N/A' }}</p>
                    <p><strong>Stage:</strong> {{ $lead['deals']['stage'] ?? 'N/A' }}</p>
                    <p><strong>Assigned Sales Reps:</strong> {{ $lead['deals']['assignedSalesRep'] ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ $lead['deals']['status'] ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Payment & Discount Section -->
            <div class="bg-white p-6 rounded-lg shadow-md lg:col-span-2">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Payment & Discount</h3>
                <div class="space-y-3">
                    <p><strong>Estimated Value:</strong> {{ $lead['payment']['estimatedValue'] ?? 'N/A' }}</p>
                    <p><strong>Discount:</strong> {{ $lead['payment']['discount'] ?? 'N/A' }}%</p>
                    <p><strong>Final Price:</strong> {{ $lead['payment']['totalPrice'] ?? 'N/A' }}</p>
                    <p><strong>Payment Terms:</strong> {{ $lead['payment']['paymentTerms'] ?? 'N/A' }}</p>
                    <p><strong>Invoice Number:</strong> {{ $lead['payment']['invoiceNumber'] ?? 'N/A' }}</p>
                    <p><strong>Payment Status:</strong> {{ $lead['payment']['paymentStatus'] ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
