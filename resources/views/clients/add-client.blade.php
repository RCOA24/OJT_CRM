@extends('layouts.app')

@section('title', 'Add New Client')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 bg-[#F5F7FA]">
    <div class="pt-20 container mx-auto bg-white shadow-xl rounded-lg p-6 max-w-[calc(100vw-2rem)] overflow-hidden">
        
        <h1 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
            <button onclick="window.history.back()" class="bg-[#205375] text-white p-2 mr-3 rounded-full hover:bg-[#102B3C] shadow-md">
                <x-backicon class="w-5 h-5" />
            </button>Clients / New Client
        </h1>

        <p class="text-sm text-gray-600 mb-4">Enter the information required to add this client.</p>

        <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
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

            @if (session('success') && session('client'))
                <div id="success-message" class="mb-4 p-4 rounded-lg bg-green-100 text-green-800">
                    <h2 class="font-bold text-lg">Client Added Successfully!</h2>
                    <div class="flex items-center mt-2">
                        <img src="{{ session('client')['photoLink'] }}" alt="Client Photo" class="w-16 h-16 rounded-full mr-4">
                        <div>
                            <p><strong>Name:</strong> {{ session('client')['fullName'] }}</p>
                            <p><strong>Email:</strong> {{ session('client')['email'] }}</p>
                            <p><strong>Phone:</strong> {{ session('client')['phoneNumber'] }}</p>
                            <p><strong>Company:</strong> {{ session('client')['companyName'] }}</p>
                            <p><strong>Website:</strong> <a href="{{ session('client')['websiteURL'] }}" class="text-blue-500 underline" target="_blank">{{ session('client')['websiteURL'] }}</a></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-semibold">Company Details:</h3>
                        <p><strong>Industry:</strong> {{ session('client')['companyDetails']['industryType'] }}</p>
                        <p><strong>Business Reg. No:</strong> {{ session('client')['companyDetails']['businessRegNumber'] }}</p>
                        <p><strong>Size:</strong> {{ session('client')['companyDetails']['companySize'] }}</p>
                        <p><strong>Address:</strong> {{ session('client')['companyDetails']['companyAddress'] }}</p>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-semibold">Contact Person:</h3>
                        @foreach (session('client')['contactPerson'] as $contact)
                            <p><strong>Name:</strong> {{ $contact['contactName'] }}</p>
                            <p><strong>Job Title:</strong> {{ $contact['jobTitle'] }}</p>
                            <p><strong>Department:</strong> {{ $contact['department'] }}</p>
                            <p><strong>Email:</strong> {{ $contact['directEmail'] }}</p>
                            <p><strong>Phone:</strong> {{ $contact['directPhone'] }}</p>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <h3 class="font-semibold">Client Details:</h3>
                        <p><strong>Lead Sources:</strong> {{ session('client')['clientDetails']['leadSources'] }}</p>
                        <p><strong>Client Type:</strong> {{ session('client')['clientDetails']['clientType'] }}</p>
                        <p><strong>Notes:</strong></p>
                        <ul class="list-disc ml-5">
                            @foreach (session('client')['clientDetails']['notes'] as $note)
                                <li>{{ $note }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
                
            @if (session('success') && session('redirectWithTimer'))
                <div id="success-message" class="mb-4 p-4 rounded-lg bg-green-100 text-green-800">
                    <h2 class="font-bold text-lg">Client Added Successfully!</h2>
                    <p>You will be redirected shortly...</p>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        setTimeout(() => {
                            window.location.href = "{{ route('clients.list') }}"; // Redirect to the clients list
                        }, 5000); // 5 seconds
                    });
                </script>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6">
                <!-- Left Column -->
                <div class="space-y-4 border border-[#EAECF0] rounded-lg p-4 space-y-6">
                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="firstName" class="block text-xs font-medium text-[#344054]">First name</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-usericon class="w-4 h-4" />
                                </span>
                                <input type="text" id="firstName" name="firstName"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter First Name" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="middleName" class="block text-xs font-medium text-[#344054]">Middle name</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-usericon class="w-4 h-4" />
                                </span>
                                <input type="text" id="middleName" name="middleName"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter Middle Name">
                            </div>
                        </div>
                        
                        <div>
                            <label for="lastName" class="block text-xs font-medium text-[#344054]">Last name</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-usericon class="w-4 h-4" />
                                </span>
                                <input type="text" id="lastName" name="lastName"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter Last Name" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-xs font-medium text-[#344054]">Email address</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-emailclienticon class="w-4 h-4" />
                                </span>
                                <input type="email" id="email" name="email"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter Email Address" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="mobileNumber" class="block text-xs font-medium text-[#344054]">Mobile number</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-mobilenumberclienticon class="w-4 h-4" />
                                </span>
                                <input type="text" id="mobileNumber" name="mobileNumber"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter Mobile Number" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="websiteUrl" class="block text-xs font-medium text-[#344054]">Website URL</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-urlclienticon class="w-4 h-4" />
                                </span>
                                <input type="url" id="websiteUrl" name="websiteUrl"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter Website URL">
                            </div>
                        </div>
                        
                    </div>

                    <!-- Contact Person -->
                    <h2 class="text-sm font-semibold text-gray-800 mt-4">Contact Person</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="contactFullName" class="block text-xs font-medium text-[#344054]">Full name</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-usericon class="w-4 h-4" />
                                </span>
                                <input type="text" id="contactFullName" name="contactFullName"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter Full Name">
                            </div>
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
                                   placeholder="Enter the Department">
                        </div>
                        <div>
                            <label for="directEmail" class="block text-xs font-medium text-[#344054]">Email address</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-emailclienticon class="w-4 h-4" />
                                </span>
                                <input type="email" id="directEmail" name="directEmail"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter the Email Address" required>
                            </div>
                        </div>
                        <div>
                            <label for="directPhoneNumber" class="block text-xs font-medium text-[#344054]">Mobile number</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-mobilenumberclienticon class="w-4 h-4" />
                                </span>
                                <input type="text" id="directPhoneNumber" name="directPhoneNumber"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter Mobile Number">
                            </div>
                        </div>
                    </div>

                    <!-- Company -->
                    <h2 class="text-sm font-semibold text-gray-800 mt-4">Company</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="companyName" class="block text-xs font-medium text-[#344054]">Company name</label>
                            
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-companyclienticon class="w-4 h-4" />
                                </span>
                                <input type="text" id="companyName" name="companyName"
                                       class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                                       placeholder="Enter the Company Name">
                            </div>
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
                                   placeholder="Enter the Business Registration Number">
                        </div>
                        <div>
                            <label for="numberOfEmployees" class="block text-xs font-medium text-[#344054]">Number of employees</label>
                            <input type="text" id="numberOfEmployees" name="numberOfEmployees" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Enter the Number of Employees">
                        </div>
                        <div>
                            <label for="city" class="block text-xs font-medium text-[#344054]">City</label>
                            <input type="text" id="city" name="city" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Enter the City">
                        </div>
                        <div>
                            <label for="stateProvince" class="block text-xs font-medium text-[#344054]">State/Province</label>
                            <input type="text" id="stateProvince" name="stateProvince" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Enter the State/Province">  
                        </div>
                        <div>
                            <label for="country" class="block text-xs font-medium text-[#344054]">Country</label>
                            <input type="text" id="country" name="country" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Enter the Country">
                        </div>
                        <div>
                            <label for="zipCode" class="block text-xs font-medium text-[#344054]">ZIP code</label>
                            <input type="text" id="zipCode" name="zipCode" 
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm" 
                                   placeholder="Enter the ZIP code">
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
                            <label for="photo" class="block text-xs font-medium text-[#344054] py-2">Upload photo</label>
                            
                            <label for="photoUpload"
                                   class="cursor-pointer border-dashed border-2 border-gray-300 rounded-lg p-6 flex justify-center items-center h-60 hover:border-blue-400 transition relative">
                                <x-uploadicon class="w-12 h-12 text-gray-400" />
                                <span class="text-sm text-gray-500 ml-3">Upload photo</span>
                                <input id="photoUpload" name="photoUpload" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                                <img id="photoPreview" class="absolute inset-0 w-full h-full object-cover rounded-lg hidden" />
                            </label>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-4">
                <button type="button" 
                        onclick="resetForm()" 
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

<script>
    function resetForm() {
        const form = document.querySelector('form');
        form.reset(); // Reset all form fields to their default values

        // Clear the photo preview if it exists
        const photoPreview = document.getElementById('photoPreview');
        const photoUpload = document.getElementById('photoUpload');
        if (photoPreview) {
            photoPreview.src = '';
            photoPreview.classList.add('hidden');
        }
        if (photoUpload) {
            photoUpload.value = ''; // Clear the file input
        }

        // Clear success messages
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.remove(); // Remove the success message if it exists
        }

        // Clear error messages
        const errorMessages = document.querySelectorAll('.text-red-500, .bg-red-500');
        errorMessages.forEach((error) => {
            error.remove(); // Remove all error messages
        });
    }

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = 'opacity 0.5s';
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 500); // Remove the element after fading out
            }, 3000); // 5 seconds
        }
    });
</script>
@endsection
