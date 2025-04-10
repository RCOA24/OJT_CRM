@extends('layouts.app')

@section('title', 'Client Details')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 bg-gray-100">
    <div class="pt-20 container mx-auto bg-white shadow-lg rounded-xl p-8 max-w-[calc(100vw-2rem)] overflow-hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <button onclick="window.history.back()" class="bg-[#205375] text-white p-3 mr-3 rounded-md hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-5 h-5" />
                </button>Client's Details
            </h1>
            <button onclick="window.location.href='{{ route('clients.add') }}'" 
                    class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                <x-addicon class="w-5 h-5 mr-2" /> Add New Client
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-1">
                <div class="bg-gray-200 rounded-xl relative">
                    <img src="{{ $client['backgroundImage'] ?? 'default-bg.jpg' }}" alt="Background" class="w-full h-40 object-cover rounded-t-xl">
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <img src="{{ $client['photoLink'] }}" alt="Client Photo" class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
                    </div>
                </div>
                <div class="text-center mt-16">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $client['fullName'] }}</h2>
                    <div class="mt-4 space-y-2">
                        <p class="flex items-center justify-center text-gray-700">
                            <x-phonedetails class="w-5 h-5 mr-2 text-gray-500" /> {{ $client['phoneNumber'] }}
                        </p>
                        <p class="flex items-center justify-center text-gray-700">
                            <x-emaildetails class="w-5 h-5 mr-2 text-gray-500" /> {{ $client['email'] }}
                        </p>
                        <p class="flex items-center justify-center text-gray-700">
                            <x-icondetails class="w-5 h-5 mr-2 text-gray-500" />
                            <a href="{{ $client['websiteURL'] }}" class="text-blue-600 underline hover:text-blue-500" target="_blank">{{ $client['websiteURL'] }}</a>
                        </p>
                    </div>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900">Notes</h3>
                    <div class="space-y-4">
                        @foreach ($client['clientDetails']['notes'] as $note)
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex items-start space-x-4">
                                <x-noteicon class="w-8 h-8 text-gray-500" />
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $note['author'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $note['role'] }}</p>
                                    <p class="mt-2 text-gray-700">{{ $note['content'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Contact Person</h3>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm space-y-2">
                        @foreach ($client['contactPerson'] as $contact)
                            <div class="flex items-start space-x-4">
                                <x-contacticon class="w-8 h-8 text-gray-500" />
                                <div>
                                    <p><strong>Name:</strong> {{ $contact['contactName'] }}</p>
                                    <p><strong>Job Title:</strong> {{ $contact['jobTitle'] }}</p>
                                    <p><strong>Department:</strong> {{ $contact['department'] }}</p>
                                    <p><strong>Email:</strong> {{ $contact['directEmail'] }}</p>
                                    <p><strong>Phone:</strong> {{ $contact['directPhone'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Companies</h3>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm space-y-2">
                        <div class="flex items-start space-x-4">
                            <x-companyicon class="w-8 h-8 text-gray-500" />
                            <div>
                                <p><strong>Company Name:</strong> {{ $client['companyDetails']['companyName'] }}</p>
                                <p><strong>Industry:</strong> {{ $client['companyDetails']['industryType'] }}</p>
                                <p><strong>Business Reg. No.:</strong> {{ $client['companyDetails']['businessRegNumber'] }}</p>
                                <p><strong>Employees:</strong> {{ $client['companyDetails']['companySize'] }}</p>
                                <p><strong>Address:</strong> {{ $client['companyDetails']['companyAddress'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
