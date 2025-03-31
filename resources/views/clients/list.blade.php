@extends('layouts.app')
@section('title', 'Client Lists')  
@include('components.sidebar')
@section('content')


    <!-- Sidebar -->


    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 pt-20">
        <div class="container mx-auto bg-white shadow rounded-lg p-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Client Lists <span class="text-sm text-gray-500">(3 client lists)</span></h1>
                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 mt-4 md:mt-0">
                    <button class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                        <x-sorticon class="w-5 h-5 mr-2" /> Sort
                    </button>
                    <button class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                        <x-filtericon class="w-5 h-5 mr-2" /> Filters
                    </button>
                    <button class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                        <x-archiveicon class="w-5 h-5 mr-2" /> Archive
                    </button>
                    <button class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                        <x-addicon class="w-5 h-5 mr-2" /> Add New Client
                    </button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="flex flex-col md:flex-row items-center mb-6 space-y-2 md:space-y-0">
                <input type="text" placeholder="Search" class="flex-1 px-4 py-2 text-[#205375] border rounded-md focus:outline-none focus:ring-2 focus:ring-[#205375] focus:border-transparent" />
                <button class="bg-[#205375] text-white px-4 py-2 rounded-md hover:bg-[#102B3C] md:ml-2">Search</button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-[#205375] font-medium">Full Name</th>
                            <th class="px-4 py-2 text-left text-[#205375] font-medium">Email</th>
                            <th class="px-4 py-2 text-left text-[#205375] font-medium">Phone Number</th>
                            <th class="px-4 py-2 text-left text-[#205375] font-medium">Company Name</th>
                            <th class="px-4 py-2 text-left text-[#205375] font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 flex items-center">
                                <img src="{{ asset('images/adminprofile.svg') }}" alt="Profile" class="w-8 h-8 rounded-full mr-2">
                                Mervin Ocharan Dayandante
                            </td>
                            <td class="px-4 py-2">mervz@gmail.com</td>
                            <td class="px-4 py-2">+63 977 058 0481</td>
                            <td class="px-4 py-2">Odecci Solutions Inc.</td>
                            <td class="px-4 py-2 flex items-center space-x-2">
                                <x-deletebin class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                <button class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 flex items-center">
                                <img src="{{ asset('images/adminprofile.svg') }}" alt="Profile" class="w-8 h-8 rounded-full mr-2">
                                Ralph Raffy Concepcion Suarez
                            </td>
                            <td class="px-4 py-2">ralph@gmail.com</td>
                            <td class="px-4 py-2">+63 977 058 0481</td>
                            <td class="px-4 py-2">Odecci Solutions Inc.</td>
                            <td class="px-4 py-2 flex items-center space-x-2">
                                <x-deletebin class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                                <button class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2 flex items-center">
                                <img src="{{ asset('images/adminprofile.svg') }}" alt="Profile" class="w-8 h-8 rounded-full mr-2">
                                Rodney Charles Austria
                            </td>
                            <td class="px-4 py-2">charles@gmail.com</td>
                            <td class="px-4 py-2">+63 977 058 0481</td>
                            <td class="px-4 py-2">Odecci Solutions Inc.</td>
                            <td class="px-4 py-2 flex items-center space-x-2">
                                <x-deletebin class="w-5 h-5 text-blue-600 hover:text-blue-800" />   
                                <button class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
