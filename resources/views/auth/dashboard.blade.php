@extends('layouts.app')

@section('title', 'Dashboard')

@include('components.sidebar')

@section('content')
<div class="flex-1 p-4 bg-gradient-to-br from-[#F9FAFB] to-[#E8EBF0] pt-20">
    <div class="container mx-auto">
        <!-- Search bar and greeting -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="relative w-full md:w-full pr-4">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-searchicon class="w-6 h-6 text-blue-600" />
                </span>
                <input id="global-search-input" type="text" placeholder="Search for anything..." 
                       class="border rounded-lg pl-10 pr-4 py-2 w-full text-sm focus:outline-none focus:ring-4 focus:ring-blue-400 shadow-md">
                <div id="search-results-dropdown" class="absolute z-10 bg-white border border-gray-200 rounded-lg shadow-lg mt-1 w-full hidden max-h-60 overflow-y-auto">
                    <!-- Search results will be dynamically added here -->
                </div>
            </div>
            <div class="flex items-center space-x-6 mt-4 md:mt-0">
                <div class="relative">
                    <span class="absolute bottom-4 right-0 bg-red-500 text-white text-xs rounded-full px-1 shadow-md">2</span>
                    <x-mailicon class="w-6 h-6 text-blue-600" />
                </div>
                <div class="relative">
                    <span class="absolute bottom-5 right-0 bg-red-500 text-white text-xs rounded-full px-1 shadow-md">5</span>
                    <x-bellicon class="w-6 h-6 text-blue-600" />
                </div>
                <x-gearicon class="w-6 h-6 text-blue-600" />
            </div>
        </div>

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-[#102B3C] to-[#205375] text-white rounded-xl shadow-xl p-6 mb-6 backdrop-blur-md">
            <h1 class="text-3xl font-extrabold">Welcome back, Mervin!</h1>
            <p class="text-sm opacity-90">Here's a quick overview of your sales performance and activities.</p>
        </div>

        <!-- Statistics Cards -->
        <h1 class="text-lg font-bold text-gray-800 mb-4">Your Sales Overview</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
            <!-- Total Clients -->
            <a href="{{ route('clients.list') }}" 
               class="block transform transition-transform duration-300 hover:scale-105"
               @click.prevent="activeItem = '/clients'; window.location.href='{{ route('clients.list') }}'">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-2xl transition-shadow">
                    <h2 class="text-xs font-semibold text-gray-600">TOTAL CLIENTS</h2>
                    <p id="total-clients-count" class="text-3xl font-extrabold text-gray-800">(0)</p>
                    <p class="text-sm text-green-500 font-semibold">+36% ↑</p>
                </div>
            </a>

            <!-- Total Users -->
            <a href="{{ route('users') }}" 
               class="block transform transition-transform duration-300 hover:scale-105"
               @click.prevent="activeItem = '/users'; window.location.href='{{ route('users') }}'">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-2xl transition-shadow">
                    <h2 class="text-xs font-semibold text-gray-600">TOTAL USERS</h2>
                    <p id="total-users-count" class="text-3xl font-extrabold text-gray-800">(0)</p>
                    <p class="text-sm text-green-500 font-semibold">+36% ↑</p>
                </div>
            </a>

            <!-- Total Leads -->
            <a href="#" 
               class="block transform transition-transform duration-300 hover:scale-105"
               @click.prevent="activeItem = '/leads'; window.location.href='#'">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-2xl transition-shadow">
                    <h2 class="text-xs font-semibold text-gray-600">TOTAL LEADS</h2>
                    <p class="text-3xl font-extrabold text-gray-800">456</p>
                    <p class="text-sm text-green-500 font-semibold">+36% ↑</p>
                </div>
            </a>

            <!-- Pending Tasks -->
            <a href="{{ route('task') }}" 
               class="block transform transition-transform duration-300 hover:scale-105"
               @click.prevent="activeItem = '/task'; window.location.href='{{ route('task') }}'">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-2xl transition-shadow">
                    <h2 class="text-xs font-semibold text-gray-600">PENDING TASK</h2>
                    <p class="text-3xl font-extrabold text-gray-800">459</p>
                    <p class="text-sm text-green-500 font-semibold">+36% ↑</p>
                </div>
            </a>
        </div>

        <!-- Sales Report and Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Sales Report</h2>
                    <div class="flex flex-wrap gap-2">
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-blue-400">12 Months</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-blue-400">6 Months</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-blue-400">30 Days</button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-blue-400">7 Days</button>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-400 flex items-center space-x-2">
                            <x-pdficon class="w-5 h-5 text-white" />
                            <span>Export PDF</span>
                        </button>
                    </div>
                </div>
                <canvas id="salesChart" class="h-48 w-full"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-2">Sales Breakdown</h2>
                <canvas id="salesBreakdownChart" class="h-48"></canvas>
            </div>
        </div>

        <!-- Sales Pipeline and Notifications -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-2">Sales Pipeline</h2>
                <canvas id="salesPipelineChart" class="h-48"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-4">Recent Notifications</h2>
                <ul class="divide-y divide-gray-200">
                    <li class="flex items-center py-3">
                        <div class="flex-shrink-0 bg-green-100 text-green-500 rounded-full p-2">
                            <x-leadaddedicon class="w-5 h-5" /> <!-- Replace with an appropriate icon -->
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600"><span class="font-bold text-green-500">New lead added</span> - Rodney Charles O. Austria</p>
                            <p class="text-xs text-gray-400">2 hours ago</p>
                        </div>
                    </li>
                    <li class="flex items-center py-3">
                        <div class="flex-shrink-0 bg-blue-100 text-blue-500 rounded-full p-2">
                            <x-meetingicon class="w-5 h-5" /> <!-- Replace with an appropriate icon -->
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600"><span class="font-bold text-blue-500">Meeting scheduled</span> with Odecci Solutions Inc.</p>
                            <p class="text-xs text-gray-400">5 hours ago</p>
                        </div>
                    </li>
                    <li class="flex items-center py-3">
                        <div class="flex-shrink-0 bg-red-100 text-red-500 rounded-full p-2">
                            <x-dealicon class="w-5 h-5" /> <!-- Replace with an appropriate icon -->
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600"><span class="font-bold text-red-500">Deal closed</span> - STI Colleges Balagtas</p>
                            <p class="text-xs text-gray-400">1 day ago</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
            <h2 class="text-sm font-semibold text-gray-700 mb-4">Recent Activities</h2>
            <ul class="divide-y divide-gray-200">
                <li class="flex items-center py-3">
                    <div class="flex-shrink-0 bg-blue-100 text-blue-500 rounded-full p-2">
                        <x-leadaddedicon class="w-5 h-5" /> <!-- Replace with an appropriate icon -->
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600"><span class="font-bold text-blue-500">New lead added</span> - Rodney Charles O. Austria</p>
                        <p class="text-xs text-gray-400">2 hours ago</p>
                    </div>
                </li>
                <li class="flex items-center py-3">
                    <div class="flex-shrink-0 bg-green-100 text-green-500 rounded-full p-2">
                        <x-meetingicon class="w-5 h-5" /> <!-- Replace with an appropriate icon -->
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600"><span class="font-bold text-green-500">Meeting scheduled</span> with Odecci Solutions Inc.</p>
                        <p class="text-xs text-gray-400">5 hours ago</p>
                    </div>
                </li>
                <li class="flex items-center py-3">
                    <div class="flex-shrink-0 bg-red-100 text-red-500 rounded-full p-2">
                        <x-dealicon class="w-5 h-5" /> <!-- Replace with an appropriate icon -->
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600"><span class="font-bold text-red-500">Deal closed</span> - STI Colleges Balagtas</p>
                        <p class="text-xs text-gray-400">1 day ago</p>
                    </div>
                </li>
                <li class="flex items-center py-3">
                    <div class="flex-shrink-0 bg-gray-100 text-gray-500 rounded-full p-2">
                        <x-gear1icon class="w-5 h-5" /> <!-- Replace with an appropriate icon -->
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">No recent activities</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const ctxBreakdown = document.getElementById('salesBreakdownChart').getContext('2d');
        const ctxPipeline = document.getElementById('salesPipelineChart').getContext('2d'); // Updated pipeline chart context

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

        // Sales Pipeline Chart (Updated to Bar Chart)
        new Chart(ctxPipeline, {
            type: 'bar',
            data: {
                labels: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00'],
                datasets: [
                    { 
                        label: 'Income', 
                        data: [15, 25, 35, 45, 55, 65, 75, 85, 95, 105], 
                        backgroundColor: '#4CAF50' 
                    },
                    { 
                        label: 'Expenses', 
                        data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100], 
                        backgroundColor: '#F44336' 
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: $${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Time'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Amount ($)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', async () => {
        const totalClientsCount = document.getElementById('total-clients-count');
        const totalUsersCount = document.getElementById('total-users-count');
        const countsApiUrl = '/dashboard/get-counts'; // New endpoint

        async function fetchCounts() {
            try {
                const response = await fetch(countsApiUrl, {
                    headers: {
                        'Cache-Control': 'no-cache', // Ensure fresh data
                        'Pragma': 'no-cache',
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                // Debugging: Log the fetched data
                console.log('Fetched Counts:', data);

                // Update the counts without parentheses
                totalClientsCount.textContent = data.totalClients;
                totalUsersCount.textContent = data.totalUsers;
            } catch (error) {
                console.error('Error fetching counts:', error);
                totalClientsCount.textContent = 'Error';
                totalUsersCount.textContent = 'Error';
            }
        }

        // Fetch counts initially and then every 10 seconds
        fetchCounts();
        setInterval(fetchCounts, 10000);
    });

    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('global-search-input');
        const searchResultsDropdown = document.getElementById('search-results-dropdown');
        const searchApiUrl = 'http://192.168.1.9:2030/api/GlobalSearch/search';

        // Function to fetch search results
        async function fetchSearchResults(query) {
            try {
                const response = await fetch(`${searchApiUrl}?search=${query}`, {
                    headers: {
                        'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error('Error fetching search results:', error);
                return [];
            }
        }

        // Function to render search results
        function renderSearchResults(results) {
            searchResultsDropdown.innerHTML = ''; // Clear previous results
            if (results.length === 0) {
                searchResultsDropdown.classList.add('hidden');
                return;
            }

            results.forEach(result => {
                const item = document.createElement('div');
                item.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                item.textContent = `${result.fullName} (${result.type})`;
                item.addEventListener('click', () => {
                    if (result.type === 'client') {
                        window.location.href = `/clients?search=${encodeURIComponent(result.fullName)}`;
                    } else if (result.type === 'user') {
                        window.location.href = `/users?search=${encodeURIComponent(result.fullName)}`;
                    }
                });
                searchResultsDropdown.appendChild(item);
            });

            searchResultsDropdown.classList.remove('hidden');
        }

        // Event listener for search input
        searchInput.addEventListener('input', async () => {
            const query = searchInput.value.trim();
            if (query.length > 0) {
                const results = await fetchSearchResults(query);
                renderSearchResults(results);
            } else {
                searchResultsDropdown.classList.add('hidden');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!searchInput.contains(event.target) && !searchResultsDropdown.contains(event.target)) {
                searchResultsDropdown.classList.add('hidden');
            }
        });
    });
</script>
@endsection
