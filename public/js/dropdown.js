document.addEventListener('DOMContentLoaded', () => {
    const sortButton = document.getElementById('sort-button');
    const sortDropdown = document.getElementById('sort-dropdown');
    const filterButton = document.getElementById('filter-button');
    const filterDropdown = document.getElementById('filter-dropdown');
    const clientTableBody = document.getElementById('client-table-body');
    const flashMessage = document.getElementById('flash-message');

    // Toggle Sort Dropdown
    sortButton.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent click from propagating to the document
        sortDropdown.classList.toggle('hidden');
    });

    // Toggle Filter Dropdown
    filterButton.addEventListener('click', () => {
        filterDropdown.classList.toggle('hidden');
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        if (!sortButton.contains(event.target) && !sortDropdown.contains(event.target)) {
            sortDropdown.classList.add('hidden');
        }
        if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
            filterDropdown.classList.add('hidden');
        }
    });

    // Fetch clients based on sorting
    sortDropdown.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', async () => {
            const sortType = button.getAttribute('data-sort');
            const queryParams = new URLSearchParams();

            // Append sorting parameters based on the selected option
            if (sortType === 'asc') {
                queryParams.append('ascending', 'true');
                showFlashMessage('Sorted by Ascending');
            } else if (sortType === 'desc') {
                queryParams.append('ascending', 'false');
                showFlashMessage('Sorted by Descending');
            } else if (sortType === 'recent') {
                queryParams.append('sortByRecentlyAdded', 'true');
                showFlashMessage('Sorted by Recently Added');
            }

            // Fetch clients with the updated query parameters
            await fetchClients(queryParams);
            sortDropdown.classList.add('hidden'); // Close dropdown after selection
        });
    });

    // Fetch clients based on filters
    filterDropdown.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', async () => {
            const industry = document.getElementById('industry-filter').value;
            const leadSource = document.getElementById('lead-source-filter').value;
            const queryParams = new URLSearchParams();

            // Append filter parameters based on the selected options
            if (industry) {
                queryParams.append('industryType', industry);
                showFlashMessage(`Filtered by Industry: ${industry}`);
            }
            if (leadSource) {
                queryParams.append('leadSource', leadSource);
                showFlashMessage(`Filtered by Lead Source: ${leadSource}`);
            }

            // Fetch clients with the updated query parameters
            await fetchClients(queryParams);
        });
    });

    // Fetch clients from the server
    async function fetchClients(queryParams) {
        try {
            const response = await fetch(`/clients/fetch?${queryParams.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const clients = await response.json();
                renderClients(clients); // Render the fetched clients in the table
            } else {
                const errorData = await response.json();
                console.error('Failed to fetch clients:', errorData.error || response.statusText);
                showFlashMessage(errorData.error || 'Failed to fetch clients. Please try again.');
            }
        } catch (error) {
            console.error('Error fetching clients:', error);
            showFlashMessage('An error occurred while fetching clients.');
        }
    }

    // Render clients in the table
    function renderClients(clients) {
        clientTableBody.innerHTML = '';

        // Display a message if no clients are found
        if (clients.length === 0) {
            clientTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No clients found.</td>
                </tr>
            `;
            return;
        }

        // Dynamically render each client row
        clients.forEach(client => {
            const row = `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 flex items-center">
                        <img src="${client.photoLink || '/images/adminprofile.svg'}" alt="Profile" class="w-10 h-10 rounded-full mr-3">
                        <a href="/clients/${client.clientId}" class="text-blue-500 hover:underline">
                            ${client.fullName || 'N/A'}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-gray-600">${client.email || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-600">${client.phoneNumber || 'N/A'}</td>
                    <td class="px-6 py-4 text-gray-600">${client.companyName || 'N/A'}</td>
                    <td class="px-6 py-4 flex items-center space-x-2">
                        <form method="POST" action="/clients/archive" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this client?');">
                            <input type="hidden" name="clientId" value="${client.clientId}">
                            <button type="submit" class="text-red-500 hover:underline">Archive</button>
                        </form>
                    </td>
                </tr>
            `;
            clientTableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    // Show flash message
    function showFlashMessage(message) {
        flashMessage.textContent = message;
        flashMessage.classList.remove('hidden', 'opacity-0', 'scale-95');
        flashMessage.classList.add('opacity-100', 'scale-100');

        // Hide the flash message after a delay
        setTimeout(() => {
            flashMessage.classList.remove('opacity-100', 'scale-100');
            flashMessage.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                flashMessage.classList.add('hidden');
            }, 500);
        }, 3000);
    }
});
