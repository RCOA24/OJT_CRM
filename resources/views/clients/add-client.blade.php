@extends('layouts.app')

@section('title', 'Add New Client')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 bg-[#F5F7FA]">
    <div class="container mx-auto bg-white shadow-xl rounded-lg p-20 max-w-[calc(100vw-2rem)] overflow-hidden">
        
        <h1 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
            <button onclick="window.history.back()" class="bg-[#205375] text-white p-2 mr-3 rounded-full hover:bg-[#102B3C] shadow-md">
                <x-backicon class="w-5 h-5" />
            </button>Clients / New Client
        </h1>

        <p class="text-sm text-gray-600 mb-4">Enter the information required to add this client.</p>

        <form action="#" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6">
                <!-- Left Column -->
                <div class="space-y-4 border border-[#EAECF0] rounded-lg p-4 space-y-6">
                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="firstName" class="block text-xs font-medium text-[#344054]">First name</label>
                            
                                <input type="text" id="firstName" name="firstName" 
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                       placeholder="Mervin" required>
                               
                         
                        </div>
                        <div>
                            <label for="middleName" class="block text-xs font-medium text-[#344054]">Middle name</label>
                            <input type="text" id="middleName" name="middleName" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Ocharan">
                        </div>
                        <div>
                            <label for="lastName" class="block text-xs font-medium text-[#344054]">Last name</label>
                            <input type="text" id="lastName" name="lastName" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Dayandante" required>
                        </div>
                        <div>
                            <label for="email" class="block text-xs font-medium text-[#344054]">Email address</label>
                            <input type="email" id="email" name="email" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="mervzz@gmail.com" required>
                        </div>
                        <div>
                            <label for="mobileNumber" class="block text-xs font-medium text-[#344054]">Mobile number</label>
                            <input type="text" id="mobileNumber" name="mobileNumber" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="+63 912 345 6789">
                        </div>
                        <div>
                            <label for="websiteUrl" class="block text-xs font-medium text-[#344054]">Website URL</label>
                            <input type="url" id="websiteUrl" name="websiteUrl" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="www.mervzd@gmail.com">
                        </div>
                    </div>

                    <!-- Contact Person -->
                    <h2 class="text-sm font-semibold text-gray-800 mt-4">Contact Person</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="contactFullName" class="block text-xs font-medium text-[#344054]">Full name</label>
                            <input type="text" id="contactFullName" name="contactFullName" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Ralph Raffy Concepcion Suarez">
                        </div>
                        <div>
                            <label for="jobTitle" class="block text-xs font-medium text-[#344054]">Job title</label>
                            <input type="text" id="jobTitle" name="jobTitle" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Developer">
                        </div>
                        <div>
                            <label for="department" class="block text-xs font-medium text-[#344054]">Department</label>
                            <input type="text" id="department" name="department" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Odecci Solutions Inc.">
                        </div>
                    </div>

                    <!-- Company -->
                    <h2 class="text-sm font-semibold text-gray-800 mt-4">Company</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="companyName" class="block text-xs font-medium text-[#344054]">Company name</label>
                            <input type="text" id="companyName" name="companyName" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Odecci Solutions Inc.">
                        </div>
                        <div>
                            <label for="industryType" class="block text-xs font-medium text-[#344054]">Industry type</label>
                            <input type="text" id="industryType" name="industryType" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="IT Industry">
                        </div>
                        <div>
                            <label for="businessRegistrationNumber" class="block text-xs font-medium text-[#344054]">Business registration number</label>
                            <input type="text" id="businessRegistrationNumber" name="businessRegistrationNumber" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="1234-567-8910">
                        </div>
                        <div>
                            <label for="numberOfEmployees" class="block text-xs font-medium text-[#344054]">Number of employees</label>
                            <input type="text" id="numberOfEmployees" name="numberOfEmployees" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="20-59">
                        </div>
                        <div>
                            <label for="city" class="block text-xs font-medium text-[#344054]">City</label>
                            <input type="text" id="city" name="city" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Balagtas">
                        </div>
                        <div>
                            <label for="stateProvince" class="block text-xs font-medium text-[#344054]">State/Province</label>
                            <input type="text" id="stateProvince" name="stateProvince" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Bulacan">
                        </div>
                        <div>
                            <label for="country" class="block text-xs font-medium text-[#344054]">Country</label>
                            <input type="text" id="country" name="country" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Philippines">
                        </div>
                        <div>
                            <label for="zipCode" class="block text-xs font-medium text-[#344054]">ZIP code</label>
                            <input type="text" id="zipCode" name="zipCode" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="3016">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4 border border-[#EAECF0] rounded-lg p-4">
                    <!-- Additional Details -->
                    <h2 class="text-sm font-semibold text-[#102B3C]">Additional Details <span class="text-xs text-gray-500">(Optional)</span></h2>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="leadSources" class="block text-xs font-medium text-[#344054]">Lead sources</label>
                            <input type="text" id="leadSources" name="leadSources" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Enter lead sources">
                        </div>
                        <div>
                            <label for="clientType" class="block text-xs font-medium text-[#344054]">Client type</label>
                            <input type="text" id="clientType" name="clientType" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Enter client type">
                        </div>
                        <div>
                            <label for="notes" class="block text-xs font-medium text-[#344054]">Notes</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                      placeholder="Enter notes"></textarea>
                        </div>
                        <div>
                            <label for="photo" class="block text-xs font-medium text-[#344054]">Upload photo</label>
                            <div class="border-dashed border-2 border-gray-300 rounded-lg p-4 flex justify-center items-center">
                                <x-uploadicon class="w-8 h-8 text-gray-400" />
                                <span class="text-xs text-gray-500 ml-2">Upload photo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 shadow-md flex items-center text-sm space-x-2">
                    <x-cancelicon class="w-4 h-4" />
                    <span>Cancel</span>
                </button>
                <button type="submit" 
                        class="bg-[#205375] text-white px-4 py-2 rounded-lg hover:bg-[#102B3C] shadow-md flex items-center text-sm space-x-2">
                    <x-saveicon class="w-4 h-4" />
                    <span>Save</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
