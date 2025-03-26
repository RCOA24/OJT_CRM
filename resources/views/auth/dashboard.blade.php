@extends('layouts.app')

@section('title', 'dashboard')

@include('components.sidebar')

@section('content')
<div class="p-4 sm:p-6 bg-gray-100 min-h-screen flex flex-col">
    <h1 class="text-2xl font-semibold mb-4">CRM Dashboard</h1>

    <div class="flex-grow">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md min-w-0">
                <h3 class="text-sm text-gray-600">Total Clients</h3>
                <p class="text-2xl font-semibold">1,230</p>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md min-w-0">
                <h3 class="text-sm text-gray-600">Active Users</h3>
                <p class="text-2xl font-semibold">350</p>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md min-w-0">
                <h3 class="text-sm text-gray-600">Revenue</h3>
                <p class="text-2xl font-semibold">$24,560</p>
            </div>
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md min-w-0">
                <h3 class="text-sm text-gray-600">New Leads</h3>
                <p class="text-2xl font-semibold">48</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="mt-4 sm:mt-6 bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-3 sm:mb-4">Sales & Revenue Analytics</h2>
            <div class="h-40 sm:h-48 bg-gray-200 flex items-center justify-center rounded-lg">
                <p class="text-gray-500 text-center">Soon</p>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="mt-4 sm:mt-6 bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-3 sm:mb-4">Recent Activities</h2>
            <ul class="space-y-2 sm:space-y-3">
                <li class="flex flex-col sm:flex-row sm:justify-between text-sm border-b pb-2">
                    <span>John Doe added a new client</span>
                    <span class="text-gray-500">5 mins ago</span>
                </li>
                <li class="flex flex-col sm:flex-row sm:justify-between text-sm border-b pb-2">
                    <span>Invoice #1023 was generated</span>
                    <span class="text-gray-500">30 mins ago</span>
                </li>
                <li class="flex flex-col sm:flex-row sm:justify-between text-sm border-b pb-2">
                    <span>New user registered: Sarah Smith</span>
                    <span class="text-gray-500">1 hour ago</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
