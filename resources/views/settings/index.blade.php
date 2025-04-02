@extends('layouts.app')

@section('title', 'Settings')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-6 bg-gray-100 pt-20">
    <div class="container mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Settings</h1>

        <!-- Tabs -->
        <div class="flex border-b mb-6">
            <button class="px-4 py-2 text-[#205375] border-b-2 border-[#205375] font-medium">Profile</button>
            <button class="px-4 py-2 text-gray-500 hover:text-[#205375]">Account</button>
            <button class="px-4 py-2 text-gray-500 hover:text-[#205375]">Preferences</button>
        </div>

        <!-- Content -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Profile Settings</h2>
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="first_name" class="mt-1 block w-full border rounded-md p-2" placeholder="Enter your first name">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="last_name" class="mt-1 block w-full border rounded-md p-2" placeholder="Enter your last name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" class="mt-1 block w-full border rounded-md p-2" placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" id="phone" class="mt-1 block w-full border rounded-md p-2" placeholder="Enter your phone number">
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C]">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
