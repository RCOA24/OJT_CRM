@extends('layouts.app')

@section('title', 'Client Details')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 bg-gray-100">
    <div class="pt-20 container mx-auto bg-white shadow-lg rounded-xl p-8 max-w-[calc(100vw-2rem)] overflow-hidden">
        {{-- Flash message for success --}}
        @if(session('success'))
            <div class="mb-6" id="flash-success">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative transition-opacity duration-700" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        {{-- Flash message for errors --}}
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
                <button onclick="window.location.href='{{ route('clients.list') }}'" class="bg-[#205375] text-white p-3 mr-3 rounded-md hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-5 h-5" />
                </button>Client's Details
            </h1>
            <div class="flex space-x-4">
                <button
                    type="button"
                    onclick="toggleEditMode()"
                    class="bg-[#205375] text-white px-5 py-3 rounded-lg border border-gray-300 hover:bg-[#102B3C] flex items-center shadow-md"
                >
                    <x-editicon1 class="w-5 h-5 mr-2" /> Edit
                </button>
                <button
                    type="submit"
                    form="edit-client-form"
                    class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md hidden"
                    id="saveButton"
                >
                    <x-saveicon class="w-5 h-5 mr-2" /> Save
                </button>
                <button onclick="window.location.href='{{ route('clients.add') }}'" 
                        class="bg-[#205375] text-white px-5 py-3 rounded-lg hover:bg-[#102B3C] flex items-center shadow-md">
                    <x-addicon class="w-5 h-5 mr-2" /> Add New Client
                </button>
            </div>
        </div>

        <form id="edit-client-form" method="POST" action="{{ isset($client['clientId']) ? route('clients.update', $client['clientId']) : '#' }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="photoLink" value="{{ $client['photoLink'] ?? '' }}">
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
                                <span class="text-gray-700" id="fullNameLabel">{{ $client['fullName'] }}</span>
                                <input type="text" name="fullName" value="{{ $client['fullName'] }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="fullNameInput" />
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-semibold">Mobile Number:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                <x-phonedetails class="w-5 h-5 mr-4 text-gray-500" />
                                <span class="text-gray-700" id="phoneNumberLabel">{{ $client['phoneNumber'] }}</span>
                                <input type="text" name="phoneNumber" value="{{ $client['phoneNumber'] }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="phoneNumberInput" />
                            </div>
                         </div>
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-semibold">Email:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                <x-emaildetails class="w-5 h-5 mr-4 text-gray-500" />
                                <span class="text-gray-700" id="emailLabel">{{ $client['email'] }}</span>
                                <input type="email" name="email" value="{{ $client['email'] }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="emailInput" />
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label class="w-1/3 text-gray-700 font-semibold">Website URL:</label>
                            <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                <x-icondetails class="w-5 h-5 mr-4 text-gray-500" />
                                <span class="text-blue-600 underline hover:text-blue-500" id="websiteURLLabel">{{ $client['websiteURL'] }}</span>
                                <input type="url" name="websiteURL" value="{{ $client['websiteURL'] }}" class="hidden text-blue-600 underline bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="websiteURLInput" />
                            </div>
                        </div>
                    </div>
                   <!-- Notes Section -->
<div class="mt-8">
    <h3 class="text-lg font-bold text-gray-900 mt-4 mb-2">Notes</h3>

    <!-- Scrollable Notes Table -->
    <div class="overflow-auto border border-gray-300 rounded-lg shadow-md max-h-24">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100 sticky top-0">
                <tr>
                    <th class="text-left px-4 py-2 text-gray-700 font-semibold text-sm">Content</th>
                    <th class="text-left px-4 py-2 text-gray-700 font-semibold text-sm">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($client['clientDetails']['notes'] ?? [] as $note)
                    <tr class="border-b">
                        <td class="px-4 py-2 text-gray-700 text-sm">{{ $note['content'] }}</td>
                        <td class="px-4 py-2 text-gray-500 text-sm">{{ \Carbon\Carbon::parse($note['createdAt'])->format('F j, Y g:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Note Section -->
    <div class="mt-4">
        <form method="POST" action="{{ route('clients.addNote', $client['clientId']) }}">
            @csrf
            <textarea name="noteContent" placeholder="Add a new note..." class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            <button type="submit" class="mt-2 bg-[#205375] text-white px-4 py-2 rounded-lg hover:bg-[#102B3C] shadow-md">Add Note</button>
        </form>
    </div>
</div>

                </div>

                <!-- Right Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact Person Section -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Person</h3>
                        <div class="space-y-3">
                            @php $contact = $client['contactPerson'][0] ?? []; @endphp
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Name:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                    <x-usericon2 class="w-5 h-5 mr-3 text-gray-500" />
                                    <span class="text-gray-700 text-sm ml-3" id="contactNameLabel0">{{ $contact['contactName'] ?? '' }}</span>
                                    <input type="text" name="contactName" value="{{ $contact['contactName'] ?? '' }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="contactNameInput0" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Job Title:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                    <x-jobicon class="w-5 h-5 mr-3 text-gray-500" />
                                    <span class="text-gray-700 text-sm ml-3" id="jobTitleLabel0">{{ $contact['jobTitle'] ?? '' }}</span>
                                    <input type="text" name="jobTitle" value="{{ $contact['jobTitle'] ?? '' }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="jobTitleInput0" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Department:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                    <x-departmenticon class="w-5 h-5 mr-3 text-gray-500" />
                                    <span class="text-gray-700 text-sm ml-3" id="departmentLabel0">{{ $contact['department'] ?? '' }}</span>
                                    <input type="text" name="department" value="{{ $contact['department'] ?? '' }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="departmentInput0" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Email:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                    <x-emaildetails class="w-5 h-5 mr-3 text-gray-500" />
                                    <span class="text-gray-700 text-sm ml-3" id="directEmailLabel0">{{ $contact['directEmail'] ?? '' }}</span>
                                    <input type="email" name="directEmail" value="{{ $contact['directEmail'] ?? '' }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="directEmailInput0" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Mobile:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-lg shadow-sm">
                                    <x-phonedetails class="w-5 h-5 mr-3 text-gray-500" />
                                    <span class="text-gray-700 text-sm ml-3" id="directPhoneLabel0">{{ $contact['directPhone'] ?? '' }}</span>
                                    <input type="text" name="directPhoneNumber" value="{{ $contact['directPhone'] ?? '' }}" class="hidden text-gray-700 bg-white border border-gray-300 rounded-lg p-2 focus:outline-none w-full" id="directPhoneInput0" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Companies Section -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Companies</h3>
                        <div class="space-y-3">
                            @php $company = $client['companyDetails'] ?? []; @endphp
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Company Name:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-companyicon1 class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3" id="companyNameLabel">{{ $company['companyName'] ?? '' }}</span>
                                    <input type="text" name="companyName" value="{{ $company['companyName'] ?? '' }}" class="hidden text-gray-800 text-sm ml-3 bg-white border border-gray-300 rounded-lg p-2 w-full" id="companyNameInput" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Industry:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-industryicon class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3" id="industryLabel">{{ $company['industryType'] ?? '' }}</span>
                                    <input type="text" name="industryType" value="{{ $company['industryType'] ?? '' }}" class="hidden text-gray-800 text-sm ml-3 bg-white border border-gray-300 rounded-lg p-2 w-full" id="industryInput" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Business Reg. No.:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-registrationicon class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3" id="businessRegNumberLabel">{{ $company['businessRegNumber'] ?? '' }}</span>
                                    <input type="text" name="businessRegNumber" value="{{ $company['businessRegNumber'] ?? '' }}" class="hidden text-gray-800 text-sm ml-3 bg-white border border-gray-300 rounded-lg p-2 w-full" id="businessRegNumberInput" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Employees:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-employeesicon class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3" id="companySizeLabel">{{ $company['companySize'] ?? '' }}</span>
                                    <input type="text" name="companySize" value="{{ $company['companySize'] ?? '' }}" class="hidden text-gray-800 text-sm ml-3 bg-white border border-gray-300 rounded-lg p-2 w-full" id="companySizeInput" />
                                </div>
                            </div>
                            <div class="flex items-center">
                                <label class="w-1/3 text-gray-700 font-medium text-sm">Address:</label>
                                <div class="flex items-center w-2/3 bg-gray-50 p-2 rounded-md border border-gray-200">
                                    <x-companyaddressicon class="w-4 h-4 mr-3 text-gray-500" />
                                    <span class="text-gray-800 text-sm ml-3" id="companyAddressLabel">{{ $company['companyAddress'] ?? '' }}</span>
                                    <input type="text" name="companyAddress" value="{{ $company['companyAddress'] ?? '' }}" class="hidden text-gray-800 text-sm ml-3 bg-white border border-gray-300 rounded-lg p-2 w-full" id="companyAddressInput" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include external JavaScript file -->
<script src="{{ asset('js/client-details.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const flash = document.getElementById('flash-success');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity 0.7s';
            flash.style.opacity = '0';
            setTimeout(() => {
                flash.style.display = 'none';
            }, 700);
        }, 3000); // 3 seconds
    }
});
</script>
@endsection
