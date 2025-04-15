@extends('layouts.app')
@section('title', 'Client Lists')  
@include('components.sidebar')
@section('content')

<div class="flex-1 p-6 bg-[#FAFBFB] pt-20">
    <div class="container mx-auto bg-white shadow-md rounded-xl p-4 sm:p-8">
        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg text-white bg-green-500 shadow-md">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg text-white bg-red-500 shadow-md">
                {{ $errors->first('error') }}
            </div>
        @endif
        <!-- Flash Message -->
        <div id="flash-message" class="hidden mb-4 p-4 rounded-lg text-white bg-[#205375] shadow-md transition-all duration-500 transform opacity-0 scale-95"></div>
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">Client Lists 
                <span id="client-count" class="text-lg text-gray-500">({{ count($clients) }} client lists)</span>
            </h1>
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 mt-4 md:mt-0">
                <div class="relative">
                    <button id="sort-button" class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                        <x-sorticon class="w-5 h-5 mr-2" /> Sort
                    </button>
                    <div id="sort-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg">
                        <div class="flex flex-col">
                            <button type="button" data-sort="asc" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-ascending class="w-5 h-5 hover:text-white" /> <span>Ascending</span>
                            </button>
                            <button type="button" data-sort="desc" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-descending class="w-5 h-5 hover:text-white" /> <span>Descending</span>
                            </button>
                            <button type="button" data-sort="recent" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-recenticon class="w-5 h-5 hover:text-white" /> <span>Recently Added</span>
                            </button>
                        </div>
                    </div>
                </div>  
                <div class="relative">
                    <button id="filter-button" class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                        <x-filtericon class="w-5 h-5 mr-2" /> Filters
                    </button>
                    <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg p-4">
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Filter by Industry <x-filtericonblack class="w-4 h-4 ml-1" />
                            </h3>
                            <select id="industry-filter" class="w-full px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select Industry</option>
                                <option value="Engineer">Engineer</option>
                                <option value="Technology">Technology</option>
                                <option value="IT Department">IT Department</option>
                                <option value="Basketball">Basketball</option>
                                <option value="Beverages">Beverages</option>
                            </select>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                Filter by Lead Source  <x-filtericonblack class="w-4 h-4 ml-1" />
                            </h3>
                            <select id="lead-source-filter" class="w-full px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select Lead Source</option>
                                <option value="referral ads">Referral Ads</option>
                                <option value="social media">Social Media</option>
                                <option value="email campaign">Email Campaign</option>
                                <option value="direct contact">Direct Contact</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <button onclick="window.location.href='{{ route('clients.archive') }}'" class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-archiveicon class="w-5 h-5 mr-2" /> Archive
                </button>
                <button onclick="window.location.href='{{ route('clients.add') }}'" 
                        class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-addicon class="w-5 h-5 mr-2" /> Add New Client
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="flex flex-col md:flex-row items-center mb-8 space-y-2 md:space-y-0">
            <input id="search-input" type="text" placeholder="Search by name" class="flex-1 px-5 py-3 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm" />
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-[#205375] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Company Name</th>
                        <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="client-table-body" class="divide-y divide-gray-200">
                    @forelse ($clients as $client)
                        <tr class="hover:bg-gray-200 transition duration-200 ease-in-out">
                            <td class="px-6 py-4 flex items-center">
                                <img src="{{ $client['photoLink'] ?? asset('images/adminprofile.svg') }}" alt="Profile" class="w-10 h-10 rounded-full mr-3">
                                <a href="{{ route('clients.show', ['id' => $client['clientId']]) }}" class="text-blue-500 hover:underline">
                                    {{ $client['fullName'] ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $client['email'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $client['phoneNumber'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $client['companyName'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 flex items-center space-x-4">
                                <form method="POST" action="{{ route('clients.archiveClient') }}" onsubmit="return confirm('Are you sure you want to archive this client?');">
                                    @csrf <!-- Ensure this is present -->
                                    <input type="hidden" name="clientId" value="{{ $client['clientId'] }}">
                                    <div class="flex items-center space-x-2">
                                        <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                        <button type="submit" class="text-red-500 hover:underline">Archive</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No clients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    window.allClients = @json($clients);
</script>
<script src="{{ asset('js/dropdown.js') }}" defer></script>
<script src="{{ asset('js/clients.js') }}"></script>
@endsection
