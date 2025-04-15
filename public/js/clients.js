document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const clientTableBody = document.getElementById('client-table-body');
    let allClients = window.allClients || [];

    // Render clients in the table
    function renderClients(clients) {
        clientTableBody.innerHTML = '';

        if (clients.length === 0) {
            clientTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No clients found.</td>
                </tr>
            `;
            return;
        }

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
                                <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800"></x-archiveredicon>
                                <button type="submit" class="text-red-500 hover:underline">Archive</button>
                            </div>
                        </form>
                    </td>
                </tr>
            `;
            clientTableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    // Handle search input
    function handleSearch() {
        const query = searchInput.value.trim().toLowerCase();
        if (query.length > 0) {
            const searchResults = allClients.filter(client => client.fullName.toLowerCase().startsWith(query));
            renderClients(searchResults);
        } else {
            renderClients(allClients); // Reset to all clients if search is empty
        }
    }

    // Debounce function to limit API calls
    function debounce(func, delay) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    searchInput.addEventListener('input', debounce(handleSearch, 300));
});
