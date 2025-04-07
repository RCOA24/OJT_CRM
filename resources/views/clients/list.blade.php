@extends('layouts.app')
@section('title', 'Client Lists')  
@include('components.sidebar')
@section('content')

    <!-- Sidebar -->

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 pt-20">
        <div class="container mx-auto bg-white shadow rounded-lg p-6 max-w-[calc(100vw-2rem)] max-h-[calc(100vh-4rem)] overflow-auto">
            <!-- Flash Message -->
            <div id="flash-message" class="hidden mb-4 p-4 rounded-lg text-white transition-all duration-500 transform opacity-0 scale-95"></div>
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
                    <div class="relative">
                        <button id="filter-button" class="bg-[#205375] text-white px-4 py-2 rounded hover:bg-[#102B3C] flex items-center">
                            <x-filtericon class="w-5 h-5 mr-2" /> Filters
                        </button>
                        <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded shadow-lg p-4">
                            <div class="mb-4">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    Filter by Industry <x-filtericonblack class="w-4 h-4 ml-1" />
                                </h3>
                                <select id="industry-filter" class="w-full px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#205375]">
                                    <option value="">Select Industry</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Technology">Technology</option>
                                    <option value="IT Department">IT Department</option>
                                    <option value="Basketball">Basketball</option>
                                    <option value="Beverages">Beverages</option>
                                </select>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    Filter by Lead Source  <x-filtericonblack class="w-4 h-4 ml-1" />
                                </h3>
                                <select id="lead-source-filter" class="w-full px-4 py-2 text-gray-700 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#205375]">
                                    <option value="">Select Lead Source</option>
                                    <option value="referral ads">Referral Ads</option>
                                    <option value="social media">Social Media</option>
                                    <option value="email campaign">Email Campaign</option>
                                    <option value="direct contact">Direct Contact</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
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
        const archiveUrl = 'http://192.168.1.9:2030/api/Clients/is-archived-client'; // Updated endpoint
        const tableBody = document.getElementById('client-table-body');
        const clientCount = document.getElementById('client-count');
        const sortDropdown = document.getElementById('sort-dropdown');
        const sortButton = document.getElementById('sort-button');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const industryFilter = document.getElementById('industry-filter');
        const leadSourceFilter = document.getElementById('lead-source-filter');

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
                        <button class="text-red-500 hover:underline archive-button" data-id="${client.clientId}">Archive</button> <!-- Fixed data-id -->
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
            const sortType = event.target.closest('button')?.getAttribute('data-sort'); // Ensure button is targeted
            if (sortType) {
                let sortedClients = [];
                if (sortType === 'asc' || sortType === 'desc') {
                    sortedClients = await fetchSortedClients(sortType === 'asc');
                } else if (sortType === 'recent') {
                    sortedClients = await fetchClients(`${apiUrl}?ascending=false&sortByRecentlyAdded=true&pageNumber=1&pageSize=10`);
                }
                renderClients(sortedClients);

                // Show flash message for the selected sort option
                const sortMessage = sortType === 'asc' ? 'Sorted by Ascending' :
                                    sortType === 'desc' ? 'Sorted by Descending' :
                                    'Sorted by Recently Added';
                showFlashMessage(sortMessage, 'success');

                // Keep the dropdown open for better UX
                sortDropdown.classList.remove('hidden');
            }
        });

        // Function to fetch sorted clients
        async function fetchSortedClients(ascending) {
            return await fetchClients(`${apiUrl}?ascending=${ascending}&sortByRecentlyAdded=false&pageNumber=1&pageSize=10`);
        }

        function showFlashMessage(message, type) {
            const flashMessage = document.getElementById('flash-message');
            flashMessage.textContent = message;
            flashMessage.className = `mb-4 p-4 rounded-lg text-white transition-all duration-500 transform ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } opacity-0 scale-95`; // Reset animation state
            flashMessage.classList.remove('hidden');
            setTimeout(() => {
                flashMessage.classList.add('opacity-100', 'scale-100'); // Fade in and scale up
            }, 10); // Slight delay for animation to apply

            setTimeout(() => {
                flashMessage.classList.remove('opacity-100', 'scale-100'); // Fade out and scale down
                flashMessage.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    flashMessage.classList.add('hidden'); // Hide after animation
                }, 500); // Match the duration of the fade-out animation
            }, 3000); // Display for 3 seconds
        }

        // Archive functionality
        tableBody.addEventListener('click', async (event) => {
            const button = event.target.closest('.archive-button'); // Ensure the button is targeted
            if (button) {
                const clientId = button.getAttribute('data-id'); // Retrieve the client ID
                if (!clientId) {
                    showFlashMessage('Client ID not found.', 'error');
                    console.error('Archive button clicked, but client ID is missing.');
                    return;
                }
                try {
                    console.log(`Attempting to archive client with ID: ${clientId}`);
                    const response = await fetch(`${archiveUrl}?isArchived=true&clientId=${clientId}`, { // Updated query parameters
                        method: 'PUT',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': '1234', // Ensure this token is valid
                            'Content-Type': 'application/json'
                        }
                    });

                    if (response.ok) {
                        showFlashMessage('Client archived successfully!', 'success');
                        console.log(`Client with ID ${clientId} archived successfully.`);
                        allClients = await fetchClients(`${apiUrl}?ascending=true&sortByRecentlyAdded=false&pageNumber=1&pageSize=10`); // Reload data
                        renderClients(allClients); // Refresh the list
                    } else {
                        const errorData = await response.json(); // Parse error response
                        console.error('Error response from server:', errorData);
                        showFlashMessage(`Failed to archive client: ${errorData.message || 'Unknown error'}`, 'error');
                    }
                } catch (error) {
                    console.error('Error occurred while archiving client:', error);
                    showFlashMessage('An error occurred while archiving the client. Please try again.', 'error');
                }
            }
        });

        // Filter functionality
        function applyFilters() {
            const selectedIndustry = industryFilter.value;
            const selectedLeadSource = leadSourceFilter.value;

            const filteredClients = allClients.filter(client => {
                const industryMatch = selectedIndustry ? client.companyDetails?.industryType === selectedIndustry : true;
                const leadSourceMatch = selectedLeadSource ? client.clientDetails?.leadSources === selectedLeadSource : true;
                return industryMatch && leadSourceMatch;
            });

            renderClients(filteredClients);
        }

        // Attach event listeners to filters
        industryFilter.addEventListener('change', applyFilters);
        leadSourceFilter.addEventListener('change', applyFilters);

        document.addEventListener('visibilitychange', async () => {
            if (document.visibilityState === 'visible') {
                allClients = await fetchClients(`${apiUrl}?ascending=true&sortByRecentlyAdded=false&pageNumber=1&pageSize=10`); // Reload data
                renderClients(allClients); // Refresh the list
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const filterButton = document.getElementById('filter-button');
        const filterDropdown = document.getElementById('filter-dropdown');

        // Toggle filter dropdown visibility
        filterButton.addEventListener('click', () => {
            filterDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
                filterDropdown.classList.add('hidden');
            }
        });

        // Maintain existing filter functionality
        const industryFilter = document.getElementById('industry-filter');
        const leadSourceFilter = document.getElementById('lead-source-filter');

        function applyFilters() {
            const selectedIndustry = industryFilter.value;
            const selectedLeadSource = leadSourceFilter.value;

            const filteredClients = allClients.filter(client => {
                const industryMatch = selectedIndustry ? client.companyDetails?.industryType === selectedIndustry : true;
                const leadSourceMatch = selectedLeadSource ? client.clientDetails?.leadSources === selectedLeadSource : true;
                return industryMatch && leadSourceMatch;
            });

            renderClients(filteredClients);
        }

        industryFilter.addEventListener('change', applyFilters);
        leadSourceFilter.addEventListener('change', applyFilters);
    });
</script>
@endsection
