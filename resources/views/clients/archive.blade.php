@extends('layouts.app')
@section('title', 'Archive Lists')
@include('components.sidebar')
@section('content')

<div class="flex-1 p-6 bg-[#FAFBFB] pt-20">
    <div class="container mx-auto bg-white shadow-md rounded-xl p-4 sm:p-8">    
        <!-- Flash Message -->
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg text-white bg-green-500">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg text-white bg-red-500">
                {{ $errors->first('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <button onclick="window.location.href='{{ route('clients.list') }}'" class="bg-[#205375] text-white p-3 rounded-full hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-6 h-6" />
                </button>
                <h1 class="text-3xl font-extrabold text-gray-800">Archived Lists</h1>
                <span class="font-semibold text-sm text-gray-500">({{ count($archivedClients) }} archived lists)</span>
            </div>
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
                <tbody id="archived-client-table-body" class="divide-y divide-gray-200">
                    @forelse ($archivedClients as $client)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 flex items-center">
                                <img src="{{ $client['photoLink'] ?? asset('images/adminprofile.svg') }}" alt="Profile" class="w-10 h-10 rounded-full mr-3">
                                <span>{{ $client['fullName'] ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $client['email'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $client['phoneNumber'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $client['companyName'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 flex items-center space-x-2">
                                <form method="POST" action="{{ route('clients.unarchive') }}" onsubmit="return confirm('Are you sure you want to unarchive this client?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="clientId" value="{{ $client['clientId'] }}">
                                    <div class="flex items-center space-x-2">
                                        <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                        <button type="submit" class="text-red-500 hover:underline">Unarchive</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No archived clients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
