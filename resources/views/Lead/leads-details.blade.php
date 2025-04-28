@extends('layouts.app')

@section('title', 'Lead & Deal Overview')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-2 sm:p-3 bg-gray-50">
    <div class="pt-20 container mx-auto bg-white shadow-md rounded-lg p-3 sm:p-4 max-w-[calc(100vw-2rem)] overflow-hidden">
        @if(session('success'))
            <div class="mb-3" id="flash-success">
                <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-1 rounded-lg relative transition-opacity duration-700" role="alert">
                    <span class="block sm:inline text-xs">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-3">
                <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-1 rounded-lg relative" role="alert">
                    <ul class="mb-0 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 space-y-2 sm:space-y-0">
            <h1 class="text-lg sm:text-xl font-bold text-gray-800 flex items-center">
                <button onclick="window.location.href='{{ route('leads.index') }}'" class="bg-[#205375] text-white p-2 mr-2 rounded-md hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-4 h-4" />
                </button>Lead & Deal
            </h1>
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                <!-- Search Bar -->
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-searchicon class="w-5 h-5 text-[#205375]" />
                    </span>
                    <input type="text" placeholder="Search" class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:ring-[#205375] focus:border-[#205375] placeholder-gray-400 text-gray-700 shadow-sm w-full">
                </div>
                <!-- Overview Button -->
                <button class="bg-white text-[#205375] px-4 py-2 rounded-lg border border-gray-300 flex items-center shadow-md">
                    <x-overviewicon class="w-5 h-5 mr-2" /> Overview
                </button>
                <!-- Edit Button -->
                <button class="bg-[#205375] text-white px-4 py-2 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-editicon1 class="w-5 h-5 mr-2" /> Edit
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Lead Management Section -->
            <div class="lg:col-span-2 bg-white p-2 sm:p-4 rounded-2xl shadow-md border">
                <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 sm:mb-3">Lead Management</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Full Name</label>
                        <input type="text" value="{{ $lead['fullName'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Email</label>
                        <input type="text" value="{{ $lead['email'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Phone</label>
                        <input type="text" value="{{ $lead['phoneNumber'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Company Name</label>
                        <input type="text" value="{{ $lead['companyName'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Industry</label>
                        <input type="text" value="{{ $lead['industry'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Lead Source</label>
                        <input type="text" value="{{ $lead['leadSource'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Status</label>
                        <input type="text" value="{{ $lead['status'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                </div>
            </div>

<!-- Notes Section -->
<div class="bg-white p-4 sm:p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col h-full">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Notes & Interaction History</h3>

    <div class="flex-1 overflow-y-auto space-y-3 pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">
        @if(is_array($lead['deals']['notes'] ?? null))
            @foreach ($lead['deals']['notes'] as $note)
                <div class="flex items-start gap-3 p-4 bg-gray-50 hover:bg-gray-100 rounded-xl shadow-sm transition-all">
                    <img src="{{ asset('images/user-placeholder.png') }}" alt="User" class="w-9 h-9 rounded-full object-cover">
                    <div class="flex flex-col">
                        <p class="text-sm font-semibold text-gray-800">Note Author</p>
                        <p class="text-sm text-gray-600 leading-snug">{{ $note }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="flex items-center justify-center p-4 bg-gray-50 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">{{ $lead['deals']['notes'] ?? 'No notes available.' }}</p>
            </div>
        @endif
    </div>
</div>



            <!-- Deal Management Section -->
            <div class="lg:col-span-2 bg-white p-2 sm:p-4 rounded-2xl shadow-md border">
                <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 sm:mb-3">Deal Management</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Deal Name</label>
                        <input type="text" value="{{ $lead['deals']['dealName'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Assigned Sales Representative</label>
                        <input type="text" value="{{ $lead['deals']['assignedSalesRep'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Deal Value</label>
                        <input type="text" value="{{ $lead['deals']['dealValue'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Currency</label>
                        <input type="text" value="{{ $lead['deals']['currency'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Stage</label>
                        <input type="text" value="{{ $lead['deals']['stage'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Status</label>
                        <input type="text" value="{{ $lead['deals']['status'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                </div>
            </div>

            <!-- Financial and Payment Section -->
            <div class="lg:col-span-2 bg-white p-2 sm:p-4 rounded-2xl shadow-md border">
                <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 sm:mb-3">Financial and Payment</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Payment Terms</label>
                        <input type="text" value="{{ $lead['payment']['paymentTerms'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Discount</label>
                        <input type="text" value="{{ $lead['payment']['discount'] ?? 'N/A' }}%" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Estimated Value</label>
                        <input type="text" value="{{ $lead['payment']['estimatedValue'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Final Price</label>
                        <input type="text" value="{{ $lead['payment']['totalPrice'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Invoice Number</label>
                        <input type="text" value="{{ $lead['payment']['invoiceNumber'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Payment Status</label>
                        <input type="text" value="{{ $lead['payment']['paymentStatus'] ?? 'N/A' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
