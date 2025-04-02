@extends('layouts.app')

@section('title', 'Dashboard')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-2 bg-gray-100 pt-20">
    <div class="container mx-auto">
        <!-- Search bar and greeting -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
            <div class="relative w-full md:w-full pr-4  ">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-searchicon class="w-6 h-6 text-blue-600" /> <!-- Font Awesome search icon -->
                </span>
                <input type="text" placeholder="Type to search" 
                       class="border rounded-lg pl-10 pr-4 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                <div class="relative">
                    <span class="absolute bottom-5 right-0 bg-red-500 text-white text-xs rounded-full px-1">2</span>
                    <x-mailicon class="w-6 h-6 text-blue-600" />
                </div>
                <div class="relative">
                    <span class="absolute bottom-5 right-0 bg-red-500 text-white text-xs rounded-full px-1">5</span>
                    <x-bellicon class="w-6 h-6 text-blue-600" />
                </div>
                <x-gearicon class="w-6 h-6 text-blue-600" />
                
            </div>
        </div>
        <h1 class="text-lg font-bold text-gray-800 mb-2">Hey Mervin - here's what's happening with your sales report.</h1>
        
        <!-- Statistics cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-xs font-semibold text-gray-600">TOTAL CLIENTS</h2>
                <p class="text-2xl font-bold text-gray-800">490</p>
                <p class="text-sm text-green-500 font-semibold">+36% ↑</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-xs font-semibold text-gray-600">TOTAL USERS</h2>
                <p class="text-2xl font-bold text-gray-800">20</p>
                <p class="text-sm text-red-500 font-semibold">-14% ↓</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-xs font-semibold text-gray-600">TOTAL LEADS</h2>
                <p class="text-2xl font-bold text-gray-800">456</p>
                <p class="text-sm text-green-500 font-semibold">+36% ↑</p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-xs font-semibold text-gray-600">PENDING TASK</h2>
                <p class="text-2xl font-bold text-gray-800">459</p>
                <p class="text-sm text-green-500 font-semibold">+36% ↑</p>
            </div>
        </div>
        
        <div class="grid grid-cols-4 md:grid-cols-2 lg:grid-cols-3 gap-1 mb-2"> <!-- Adjusted grid for all screen sizes -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-4"> <!-- Updated padding -->
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Sales Report</h2>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">12 Months</button>
                        <button class="px-3 py-1 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">6 Months</button>
                        <button class="px-3 py-1 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">30 Days</button>
                        <button class="px-3 py-1 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">7 Days</button>
                        <button class="px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center space-x-2">
                            <x-pdficon class="w-5 h-5 text-white" /> <!-- Adjusted icon size and color -->
                            <span>Export PDF</span>
                        </button>
                    </div>
                </div>
                <canvas id="salesChart" class="h-40"></canvas> <!-- Increased height -->
            </div>
            <div class="bg-white rounded-lg shadow-lg p-2"> <!-- Added shadow-lg -->
                <h2 class="text-xs font-semibold text-gray-700 mb-1">Sales</h2>
                <canvas id="salesBreakdownChart" class="h-20"></canvas> <!-- Reduced height -->
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1"> <!-- Adjusted grid for all screen sizes -->
            <div class="bg-white rounded-lg shadow-lg p-2"> <!-- Added shadow-lg -->
                <h2 class="text-xs font-semibold text-gray-700 mb-1">Sales Pipeline</h2>
                <canvas id="salesPipelineChart" class="h-20"></canvas> <!-- Added canvas for sales pipeline chart -->
            </div>
            <div class="bg-white rounded-lg shadow-lg p-2"> <!-- Added shadow-lg -->
                <h2 class="text-xs font-semibold text-gray-700 mb-1">Recent Notifications</h2>
                <ul class="space-y-1 text-xs">
                    <li class="text-gray-600"><span class="text-green-500 font-bold">New lead added</span> - Rodney Charles O. Austria</li>
                    <li class="text-gray-600"><span class="text-blue-500 font-bold">Meeting scheduled</span> with Odecci Solutions Inc.</li>
                    <li class="text-gray-600"><span class="text-red-500 font-bold">Deal closed</span> - STI Colleges Balagtas</li>
                </ul>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-2 mt-2"> <!-- Added shadow-lg -->
            <h2 class="text-xs font-semibold text-gray-700 mb-1">Recent Activities</h2>
            <p class="text-gray-500 text-center text-xs">No recent activities</p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const ctxBreakdown = document.getElementById('salesBreakdownChart').getContext('2d');
        const ctxPipeline = document.getElementById('salesPipelineChart').getContext('2d'); // Added pipeline chart context

        // Sales Report Chart
        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00'],
                datasets: [
                    { label: 'Income', data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100], borderColor: '#4CAF50', fill: false },
                    { label: 'Expenses', data: [5, 15, 25, 35, 45, 55, 65, 75, 85, 95], borderColor: '#F44336', fill: false }
                ]
            }
        });

        // Sales Breakdown Chart
        new Chart(ctxBreakdown, {
            type: 'doughnut',
            data: {
                labels: ['Sales Total', 'Sales Revenue', 'Sales Growth'],
                datasets: [{ data: [12, 20, 67], backgroundColor: ['#4CAF50', '#2196F3', '#FFC107'] }]
            }
        });

        // Sales Pipeline Chart
        new Chart(ctxPipeline, {
            type: 'line',
            data: {
                labels: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00'],
                datasets: [
                    { label: 'Income', data: [15, 25, 35, 45, 55, 65, 75, 85, 95, 105], borderColor: '#4CAF50', fill: false },
                    { label: 'Expenses', data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100], borderColor: '#F44336', fill: false }
                ]
            }
        });
    });
</script>
@endsection
