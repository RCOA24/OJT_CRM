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
        </div>

        <form method="POST" action="{{ route('leads.store') }}">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Lead Management Section -->
                <div class="lg:col-span-2 bg-white p-2 sm:p-4 rounded-2xl shadow-md border">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 sm:mb-3">Lead Management</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                        @foreach (['fullName' => 'Full Name', 'email' => 'Email', 'phoneNumber' => 'Phone', 'companyName' => 'Company Name', 'industry' => 'Industry', 'leadSource' => 'Lead Source', 'status' => 'Status'] as $field => $label)
                            <div>
                                <label class="block text-xs font-semibold text-gray-600">{{ $label }}</label>
                                <input id="{{ $field }}Input" type="text" name="{{ $field }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs" required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col h-full">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Notes & Interaction History</h3>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Notes</label>
                    <textarea class="w-full h-40 border border-gray-300 rounded-md p-3 resize-none text-xs" placeholder="Notes..."></textarea>
                </div>

                <!-- Deal Management Section -->
                <div class="lg:col-span-2 bg-white p-2 sm:p-4 rounded-2xl shadow-md border">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 sm:mb-3">Deal Management</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                        @foreach (['dealName' => 'Deal Name', 'assignedSalesRep' => 'Assigned Sales Representative', 'dealValue' => 'Deal Value', 'currency' => 'Currency', 'stage' => 'Stage', 'dealStatus' => 'Deal Status'] as $field => $label)
                            <div>
                                <label class="block text-xs font-semibold text-gray-600">{{ $label }}</label>
                                <input id="{{ $field }}Input" type="text" name="{{ $field }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Financial and Payment Section -->
                <div class="lg:col-span-2 bg-white p-2 sm:p-4 rounded-2xl shadow-md border">
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-2 sm:mb-3">Financial and Payment</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3">
                        @foreach (['paymentTerms' => 'Payment Terms', 'discounts' => 'Discount', 'estimatedValue' => 'Estimated Value', 'finalPrice' => 'Final Price', 'invoiceNumber' => 'Invoice Number', 'paymentStatus' => 'Payment Status'] as $field => $label)
                            <div>
                                <label class="block text-xs font-semibold text-gray-600">{{ $label }}</label>
                                <input id="{{ $field }}Input" type="text" name="{{ $field }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#205375] focus:border-[#205375] text-xs">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-[#205375] text-white px-6 py-3 rounded-lg hover:bg-[#102B3C] shadow-md">
                    Add Lead
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
