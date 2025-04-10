@extends('layouts.app')
@section('title', 'Archive Lists')
@include('components.sidebar')
@section('content')

<div class="flex-1 p-6 bg-[#FAFBFB] pt-20">
    <div class="container mx-auto bg-white shadow-lg rounded-xl p-8 max-w-[calc(100vw-2rem)] max-h-[calc(100vh-4rem)] overflow-auto">
        <!-- Flash Message -->
        <div id="flash-message" class="hidden mb-4 p-4 rounded-lg text-white transition-all duration-500 transform opacity-0 scale-95"></div>
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <button onclick="window.history.back()" class="bg-[#205375] text-white p-3 rounded-full hover:bg-[#102B3C] shadow-md">
                    <x-backicon class="w-6 h-6" />
                </button>
                <h1 class="text-3xl font-extrabold text-gray-800">Archived Lists</h1>
                <span id="archive-count" class="font-semibold text-sm text-gray-500">(0 client lists)</span>
            </div>
            <div class="relative w-full md:w-1/3">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-searchicon class="w-5 h-5 text-blue-600" />
                </span>
                <input id="search-input" type="text" placeholder="Search" 
                       class="border border-gray-300 rounded-full pl-10 pr-4 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-[#102B3C] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">
                            <div class="flex items-center">
                                Full Name
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">Company Name</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="archive-table-body" class="divide-y divide-gray-200">
                    <!-- Dynamic rows will be appended here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const apiUrl = 'http://192.168.1.9:2030/api/Clients/all-archieve-clients';
        const unarchiveUrl = 'http://192.168.1.9:2030/api/Clients/is-archived-client';
        const tableBody = document.getElementById('archive-table-body');
        const archiveCount = document.getElementById('archive-count');

        function showFlashMessage(message, type) {
            const flashMessage = document.getElementById('flash-message');
            flashMessage.textContent = message;
            flashMessage.className = `mb-4 p-4 rounded-lg text-white transition-all duration-500 transform ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } opacity-0 scale-95`;
            flashMessage.classList.remove('hidden');
            setTimeout(() => {
                flashMessage.classList.add('opacity-100', 'scale-100');
            }, 10);

            setTimeout(() => {
                flashMessage.classList.remove('opacity-100', 'scale-100');
                flashMessage.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    flashMessage.classList.add('hidden');
                }, 500);
            }, 3000);
        }

        async function fetchArchivedClients() {
            try {
                const response = await fetch(apiUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P'
                    }
                });
                const data = await response.json();
                return data || [];
            } catch (error) {
                console.error('Error fetching archived clients:', error);
                return [];
            }
        }

        async function unarchiveClient(clientId) {
            try {
                const response = await fetch(`${unarchiveUrl}?isArchived=false&clientId=${clientId}`, {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P'
                    }
                });
                if (response.ok) {
                    showFlashMessage('Client unarchived successfully!', 'success');
                    loadArchivedClients();
                } else {
                    const errorData = await response.json();
                    showFlashMessage(`Failed to unarchive client: ${errorData.message || 'Unknown error'}`, 'error');
                }
            } catch (error) {
                showFlashMessage('An error occurred while unarchiving the client. Please try again.', 'error');
            }
        }

        function renderArchivedClients(clients) {
            tableBody.innerHTML = '';
            archiveCount.textContent = `${clients.length} archived lists`;

            clients.forEach(client => {
                const row = document.createElement('tr');
                row.classList.add('hover:bg-gray-100', 'transition', 'duration-150', 'ease-in-out');
                row.innerHTML = `
                    <td class="px-6 py-4 flex items-center">
                        <img src="${client.photoLink || '{{ asset('images/adminprofile.svg') }}'}" alt="Profile" class="w-10 h-10 rounded-full mr-3 shadow-md">
                        <span class="text-gray-700 font-medium">${client.fullName || 'N/A'}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">${client.email || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-600">${client.phoneNumber || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-600">${client.companyName || 'N/A'}</td>
                    <td class="px-6 py-4 flex items-center space-x-4">
                        <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                        <button class="text-red-500 hover:text-red-700 font-medium unarchive-button" data-id="${client.clientId}">Unarchive</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            document.querySelectorAll('.unarchive-button').forEach(button => {
                button.addEventListener('click', (e) => {
                    const clientId = e.target.getAttribute('data-id');
                    unarchiveClient(clientId);
                });
            });
        }

        async function loadArchivedClients() {
            const archivedClients = await fetchArchivedClients();
            renderArchivedClients(archivedClients);
        }

        loadArchivedClients();
    });
</script>
@endsection
