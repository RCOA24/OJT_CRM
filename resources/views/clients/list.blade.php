@extends('layouts.app')
@section('title', 'Client Lists')  
@include('components.sidebar')
@section('content')

    <!-- Sidebar -->

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 pt-20">
        <div class="container mx-auto bg-white shadow rounded-lg p-6 max-w-[calc(100vw-2rem)] max-h-[calc(100vh-4rem)] overflow-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Client Lists <span id="client-count" class="text-sm text-gray-500">(0 client lists)</span></h1>
                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 mt-4 md:mt-0">
                    <div class="relative">
                        <button id="sort-button" class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                            <x-sorticon class="w-5 h-5 mr-2" /> Sort
                        </button>
                        <div id="sort-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-[#FAFBFB] border rounded shadow-lg">
                            <button data-sort="asc" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-ascending class="w-5 h-5 hover:text-white" /> <span>Ascending</span>
                            </button>
                            <button data-sort="desc" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-descending class="w-5 h-5 hover:text-white" /> <span>Descending</span>
                            </button>
                            <button data-sort="recent" class="flex items-center space-x-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-[#205375] hover:text-white">
                                <x-recenticon class="w-5 h-5 hover:text-white" /> <span>Recently Added</span>
                            </button>
                        </div>
                    </div>  
                    <button class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                        <x-filtericon class="w-5 h-5 mr-2" /> Filters
                    </button>
                    <button onclick="window.location.href='{{ route('clients.archive') }}'" class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                        <x-archiveicon class="w-5 h-5 mr-2" /> Archive
                    </button>
                    <button class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                        <x-addicon class="w-5 h-5 mr-2" /> Add New Client
                    </button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="flex flex-col md:flex-row items-center mb-6 space-y-2 md:space-y-0">
                <input id="search-input" type="text" placeholder="Search" class="flex-1 px-4 py-2 text-[#205375] border rounded-md focus:outline-none focus:ring-2 focus:ring-[#205375] focus:border-transparent" />
                <button id="search-button" class="bg-[#205375] text-white px-4 py-2 rounded-md hover:bg-[#102B3C] md:ml-2">Search</button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-[#205375] text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Full Name</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Phone Number</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Company Name</th>
                            <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="client-table-body" class="divide-y divide-gray-200">
                        <!-- Dynamic rows will be appended here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const apiUrl = 'http://192.168.1.9:2030/api/Clients/all-clients';
        const searchUrl = 'http://192.168.1.9:2030/api/Clients/search-client';
        const tableBody = document.getElementById('client-table-body');
        const clientCount = document.getElementById('client-count');
        const sortDropdown = document.getElementById('sort-dropdown');
        const sortButton = document.getElementById('sort-button');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');

        let allClients = [];

        async function fetchClients(url) {
            try {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': '1234'
                    }
                });
                const data = await response.json();
                return data.items || []; // Adjust to match the "items" array in the API response
            } catch (error) {
                console.error('Error fetching clients:', error);
                return [];
            }
        }

        function renderClients(clients) {
            tableBody.innerHTML = '';
            clientCount.textContent = `(${clients.length} client lists)`;

            clients.forEach(client => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-50');
                row.innerHTML = `
                    <td class="px-6 py-4 flex items-center">
                        <img src="{{ asset('images/adminprofile.svg') }}" alt="Profile" class="w-10 h-10 rounded-full mr-3">
                        ${client.fullName || 'N/A'}
                    </td>
                    <td class="px-6 py-4 text-gray-600">${client.email || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-600">${client.phoneNumber || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-600">${client.companyName || 'N/A'}</td>
                    <td class="px-6 py-4 flex items-center space-x-4">
                        <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                        <button class="text-red-500 hover:underline archive-button" data-id="${client.id}">Archive</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Fetch and display all clients on page load
        allClients = await fetchClients(`${apiUrl}?ascending=true&sortByRecentlyAdded=false&pageNumber=1&pageSize=10`);
        renderClients(allClients);

        // Search functionality triggered on input
        async function handleSearch() {
            const query = searchInput.value.trim().toLowerCase();
            if (query.length > 0) {
                const searchResults = allClients.filter(client => client.fullName.toLowerCase().startsWith(query));
                renderClients(searchResults);
            } else {
                renderClients(allClients); // Reset to all clients if search is empty
            }
        }

        searchInput.addEventListener('input', debounce(handleSearch, 300));

        // Debounce function to limit API calls
        function debounce(func, delay) {
            let timeout;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), delay);
            };
        }

        // Toggle sort dropdown
        sortButton.addEventListener('click', () => {
            sortDropdown.classList.toggle('hidden');
        });

        // Handle sorting
        sortDropdown.addEventListener('click', async (event) => {
            const sortType = event.target.getAttribute('data-sort');
            if (sortType) {
                let sortedClients = [];
                if (sortType === 'asc' || sortType === 'desc') {
                    sortedClients = await fetchSortedClients(sortType === 'asc');
                } else if (sortType === 'recent') {
                    sortedClients = await fetchClients(`${apiUrl}?ascending=false&sortByRecentlyAdded=true&pageNumber=1&pageSize=10`);
                }
                renderClients(sortedClients);
                sortDropdown.classList.add('hidden');
            }
        });

        // Function to fetch sorted clients
        async function fetchSortedClients(ascending) {
            return await fetchClients(`${apiUrl}?ascending=${ascending}&sortByRecentlyAdded=false&pageNumber=1&pageSize=10`);
        }

        // Archive functionality
        tableBody.addEventListener('click', async (event) => {
            const button = event.target.closest('.archive-button'); // Ensure the button is targeted
            if (button) {
                const clientId = button.getAttribute('data-id'); // Correctly retrieve the data-id
                if (!clientId) {
                    alert('Client ID not found.');
                    return;
                }
                try {
                    const response = await fetch(`http://192.168.1.9:2030/api/Clients/archived-client/${clientId}`, {
                        method: 'PUT',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': '1234',
                            'Content-Type': 'application/json'
                        }
                    });

                    if (response.ok) {
                        alert('Client archived successfully!');
                        location.reload(); // Refresh the page to update the list
                    } else {
                        alert('Failed to archive client.');
                    }
                } catch (error) {
                    console.error('Error archiving client:', error);
                }
            }
        });
    });
</script>
@endsection
