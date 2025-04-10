@extends('layouts.app')

@section('title', 'Client Details')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 bg-[#F5F7FA]">
    <div class="pt-20 container mx-auto bg-white shadow-xl rounded-lg p-6 max-w-[calc(100vw-2rem)] overflow-hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Client Details</h1>
            <div class="flex space-x-3">
                <button onclick="window.history.back()" class="bg-[#205375] text-white px-4 py-2 rounded-lg hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-5 h-5" />
                </button>
                <a href="{{ route('clients.add') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 shadow-md">
                    + Add New Client
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <img src="{{ $client['photoLink'] }}" alt="Client Photo" class="w-24 h-24 rounded-full shadow-md">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $client['firstName'] }} {{ $client['middleName'] }} {{ $client['lastName'] }}</h2>
                        <p class="text-gray-600"><strong>Mobile Number:</strong> {{ $client['phoneNumber'] }}</p>
                        <p class="text-gray-600"><strong>Email:</strong> {{ $client['email'] }}</p>
                        <p class="text-gray-600"><strong>Website URL:</strong> <a href="{{ $client['websiteUrl'] }}" class="text-blue-500 underline" target="_blank">{{ $client['websiteUrl'] }}</a></p>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800">Notes</h3>
                    <ul class="list-disc ml-5 text-gray-600">
                        @foreach ($client['details']['notes'] as $note)
                            <li>{{ $note }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-gray-800">Contact Person</h3>
                    @foreach ($client['contact'] as $contact)
                        <p><strong>Contact Person Name:</strong> {{ $contact['contactName'] }}</p>
                        <p><strong>Job Title:</strong> {{ $contact['jobTitle'] }}</p>
                        <p><strong>Department:</strong> {{ $contact['department'] }}</p>
                        <p><strong>Email:</strong> {{ $contact['directEmail'] }}</p>
                        <p><strong>Mobile Number:</strong> {{ $contact['directPhoneNumber'] }}</p>
                    @endforeach
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800">Company</h3>
                    <p><strong>Company Name:</strong> {{ $client['company']['companyName'] }}</p>
                    <p><strong>Industry:</strong> {{ $client['company']['industryType'] }}</p>
                    <p><strong>Business Registration No.:</strong> {{ $client['company']['businessRegNumber'] }}</p>
                    <p><strong>Number of Employees:</strong> {{ $client['company']['companySize'] }}</p>
                    <p><strong>Company Address:</strong> {{ $client['company']['city'] }}, {{ $client['company']['stateProvince'] }}, {{ $client['company']['country'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
