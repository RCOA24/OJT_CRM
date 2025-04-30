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
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'w-full text-left px-4 py-2 hover:bg-gray-100 cursor-pointer focus:outline-none';
            item.textContent = `${result.fullName} (${result.type})`;
            item.addEventListener('click', () => {
                if (result.type === 'client') {
                    window.location.href = '/clients/list';
                } else if (result.type === 'user') {
                    window.location.href = '/users';
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