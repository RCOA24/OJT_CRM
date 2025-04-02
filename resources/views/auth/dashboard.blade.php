@extends('layouts.app')

@section('title', 'Dashboard')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-2 bg-gray-100 pt-20">
    <div class="container mx-auto">
        <h1 class="text-lg font-bold text-gray-800 mb-2">Dashboard</h1>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-1 mb-2"> <!-- Adjusted grid for all screen sizes -->
            <div class="bg-yellow-400 text-white rounded-lg shadow-lg p-2 flex justify-between"> <!-- Added shadow-lg -->
                <div><h2 class="text-xs font-semibold">Total Clients</h2><p class="text-lg font-bold">490</p></div>
            </div>  
            <div class="bg-green-400 text-white rounded-lg shadow-lg p-2 flex justify-between"> <!-- Added shadow-lg -->
                <div><h2 class="text-xs font-semibold">Total Users</h2><p class="text-lg font-bold">390</p></div>
            </div>
            <div class="bg-orange-400 text-white rounded-lg shadow-lg p-2 flex justify-between"> <!-- Added shadow-lg -->
                <div><h2 class="text-xs font-semibold">Total Leads</h2><p class="text-lg font-bold">456</p></div>
            </div>
            <div class="bg-blue-400 text-white rounded-lg shadow-lg p-2 flex justify-between"> <!-- Added shadow-lg -->
                <div><h2 class="text-xs font-semibold">Pending Tasks</h2><p class="text-lg font-bold">459</p></div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 mb-2"> <!-- Adjusted grid for all screen sizes -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-2"> <!-- Added shadow-lg -->
                <h2 class="text-xs font-semibold text-gray-700 mb-1">Sales Report</h2>
                <canvas id="salesChart" class="h-20"></canvas> <!-- Reduced height -->
            </div>
            <div class="bg-white rounded-lg shadow-lg p-2"> <!-- Added shadow-lg -->
                <h2 class="text-xs font-semibold text-gray-700 mb-1">Sales</h2>
                <canvas id="salesBreakdownChart" class="h-20"></canvas> <!-- Reduced height -->
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1"> <!-- Adjusted grid for all screen sizes -->
            <div class="bg-white rounded-lg shadow-lg p-2"> <!-- Added shadow-lg -->
                <h2 class="text-xs font-semibold text-gray-700 mb-1">Sales Pipeline</h2>
                <p class="text-gray-500 text-center text-xs">No data available</p>
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
        new Chart(ctxBreakdown, {
            type: 'doughnut',
            data: {
                labels: ['Sales Total', 'Sales Revenue', 'Sales Growth'],
                datasets: [{ data: [12, 20, 67], backgroundColor: ['#4CAF50', '#2196F3', '#FFC107'] }]
            }
        });
    });
</script>
@endsection
