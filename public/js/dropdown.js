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
                            <div class="flex items-center space-x-2">
                                <!-- Replace Blade component with SVG -->
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.93 3.035L14.5967 0.368333C14.5412 0.257574 14.4561 0.164443 14.3507 0.0993848C14.2453 0.0343261 14.1239 -8.85003e-05 14 1.70918e-07H2C1.87615 -8.85003e-05 1.75472 0.0343261 1.64933 0.0993848C1.54394 0.164443 1.45876 0.257574 1.40333 0.368333L0.07 3.035C0.0240473 3.12774 9.37374e-05 3.22983 0 3.33333V14.6667C0 15.0203 0.140476 15.3594 0.390524 15.6095C0.640573 15.8595 0.979711 16 1.33333 16H14.6667C15.0203 16 15.3594 15.8595 15.6095 15.6095C15.8595 15.3594 16 15.0203 16 14.6667V3.33333C15.9999 3.22983 15.976 3.12774 15.93 3.035ZM2.41167 1.33333H13.5883L14.255 2.66667H1.745L2.41167 1.33333ZM14.6667 14.6667H1.33333V4H14.6667V14.6667ZM11.1383 8.195C11.2003 8.25694 11.2494 8.33047 11.2829 8.4114C11.3165 8.49233 11.3337 8.57907 11.3337 8.66667C11.3337 8.75426 11.3165 8.841 11.2829 8.92193C11.2494 9.00286 11.2003 9.07639 11.1383 9.13833C11.0764 9.20027 11.0029 9.24941 10.9219 9.28293C10.841 9.31645 10.7543 9.3337 10.6667 9.3337C10.5791 9.3337 10.4923 9.31645 10.4114 9.28293C10.3305 9.24941 10.2569 9.20027 10.195 9.13833L8.66667 7.60917V12.6667C8.66667 12.8435 8.59643 13.013 8.47141 13.1381C8.34638 13.2631 8.17681 13.3333 8 13.3333C7.82319 13.3333 7.65362 13.2631 7.5286 13.1381C7.40357 13.013 7.33333 12.8435 7.33333 12.6667V7.60917L5.805 9.13833C5.74306 9.20027 5.66953 9.24941 5.5886 9.28293C5.50767 9.31645 5.42093 9.3337 5.33333 9.3337C5.24574 9.3337 5.159 9.31645 5.07807 9.28293C4.99714 9.24941 4.92361 9.20027 4.86167 9.13833C4.79973 9.07639 4.75059 9.00286 4.71707 8.92193C4.68355 8.841 4.6663 8.75426 4.6663 8.66667C4.6663 8.57907 4.68355 8.49233 4.71707 8.4114C4.75059 8.33047 4.79973 8.25694 4.86167 8.195L7.52833 5.52833C7.59025 5.46635 7.66377 5.41718 7.74471 5.38363C7.82564 5.35008 7.91239 5.33281 8 5.33281C8.08761 5.33281 8.17436 5.35008 8.25529 5.38363C8.33622 5.41718 8.40975 5.46635 8.47167 5.52833L11.1383 8.195Z" fill="#ED1C24"/>
                                </svg>
                                <button type="submit" class="text-red-500 hover:underline">Archive</button>
                            </div>
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
