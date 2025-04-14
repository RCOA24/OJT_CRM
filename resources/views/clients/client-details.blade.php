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
            <div class="flex space-x-4">
                <!-- New Buttons -->
                <button class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-overviewicon class="w-5 h-5 mr-2" /> Overview
                </button>
                <button class="bg-[#205375] text-white px-5 py-3 rounded-lg border border-gray-300 hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-editicon1 class="w-5 h-5 mr-2" /> Edit
                </button>
                <button class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-saveicon class="w-5 h-5 mr-2 ml" /> Save
                </button>
                <button onclick="window.location.href='{{ route('clients.add') }}'" 
                        class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-addicon class="w-5 h-5 mr-2" /> Add New Client
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-gray-200 rounded-xl relative">
                    <img src="{{ asset($client['backgroundImage'] ?? 'images/example.jpg') }}" alt="Background" class="w-full h-40 object-cover rounded-t-xl">

                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <img src="{{ $client['photoLink'] }}" alt="Client Photo" class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
                    </div>
                </div>
                <div class="mt-12 space-y-4">
                    <div class="flex items-center">
                        <label class="w-1/3 text-gray-700 font-semibold">Full Name:</label>
                        <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                            <x-usericon2 class="w-5 h-5 mr-4 text-gray-500" />
                            <span class="text-gray-700">{{ $client['fullName'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/3 text-gray-700 font-semibold">Mobile Number:</label>
                        <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                            <x-phonedetails class="w-5 h-5 mr-4 text-gray-500" />
                            <span class="text-gray-700">{{ $client['phoneNumber'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/3 text-gray-700 font-semibold">Email:</label>
                        <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                            <x-emaildetails class="w-5 h-5 mr-4 text-gray-500" />
                            <span class="text-gray-700">{{ $client['email'] }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-1/3 text-gray-700 font-semibold">Website URL:</label>
                        <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                            <x-icondetails class="w-5 h-5 mr-4 text-gray-500" />
                            <a href="{{ $client['websiteURL'] }}" class="text-blue-600 underline hover:text-blue-500">{{ $client['websiteURL'] }}</a>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Notes</h3>
                    <div class="space-y-4">
                        @foreach ($client['clientDetails']['notes'] as $note)
                            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                                <p class="text-gray-700 text-sm">{{ $note }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <textarea placeholder="Add a new note..." class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        <button class="mt-2 bg-[#205375] text-white px-4 py-2 rounded-lg hover:bg-[#102B3C] shadow-md">Add Note</button>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Person Section -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Person</h3>
                    <div class="space-y-3">
                        @foreach ($client['contactPerson'] as $contact)
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Name:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-usericon2 class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3">{{ $contact['contactName'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Job Title:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-jobicon class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3">{{ $contact['jobTitle'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Department:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-departmenticon class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3">{{ $contact['department'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Email:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-emaildetails class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3">{{ $contact['directEmail'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Mobile:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-phonedetails class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3">{{ $contact['directPhone'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Companies Section -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Companies</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium text-sm">Company Name:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                <x-companyicon1 class="w-4 h-4 mr-3 text-gray-500" />
                                <span class="text-gray-800 text-sm ml-3">{{ $client['companyDetails']['companyName'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium text-sm">Industry:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                <x-industryicon class="w-4 h-4 mr-3 text-gray-500" />
                                <span class="text-gray-800 text-sm ml-3">{{ $client['companyDetails']['industryType'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium text-sm">Business Reg. No.:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                <x-registrationicon class="w-4 h-4 mr-3 text-gray-500" />
                                <span class="text-gray-800 text-sm ml-3">{{ $client['companyDetails']['businessRegNumber'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium text-sm">Employees:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                <x-employeesicon class="w-4 h-4 mr-3 text-gray-500" />
                                <span class="text-gray-800 text-sm ml-3">{{ $client['companyDetails']['companySize'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-medium text-sm">Address:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                <x-companyaddressicon class="w-4 h-4 mr-3 text-gray-500" />
                                <span class="text-gray-800 text-sm ml-3">{{ $client['companyDetails']['companyAddress'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
