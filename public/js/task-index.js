document.addEventListener('DOMContentLoaded', () => {
    const sortButton = document.getElementById('sort-button');
    const sortDropdown = document.getElementById('sort-dropdown');
    const filterButton = document.getElementById('filter-button');
    const filterDropdown = document.getElementById('filter-dropdown');
    const flashMessage = document.getElementById('flash-message');
    const flashMessageText = document.getElementById('flash-message-text');
    const applyFiltersButton = document.getElementById('apply-filters');
    const searchInput = document.getElementById('search-input');
    const taskTableBody = document.getElementById('task-table-body');

    // Toggle sort dropdown visibility
    sortButton.addEventListener('click', () => {
        sortDropdown.classList.toggle('hidden');
    });

    // Close sort dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!sortButton.contains(event.target) && !sortDropdown.contains(event.target)) {
            sortDropdown.classList.add('hidden');
        }
    });

    // Toggle filter dropdown visibility
    filterButton.addEventListener('click', () => {
        filterDropdown.classList.toggle('hidden');
    });

    // Close filter dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
            filterDropdown.classList.add('hidden');
        }
    });

    // Handle sort button clicks
    document.querySelectorAll('button[data-sort]').forEach(button => {
        button.addEventListener('click', () => {
            const sortType = button.getAttribute('data-sort');
            const ascending = sortType === 'asc';
            fetchSortedTasks(ascending);

            // Show flash message
            flashMessageText.textContent = ascending ? 'Tasks sorted in ascending order.' : 'Tasks sorted in descending order.';
            flashMessage.classList.remove('hidden');
            setTimeout(() => {
                flashMessage.classList.add('hidden');
            }, 3000); // Hide after 3 seconds
        });
    });

    // Handle filter application
    applyFiltersButton.addEventListener('click', async () => {
        const taskType = document.getElementById('task-type-filter').value;
        const priority = document.getElementById('priority-filter').value;
        const dueDateFrom = document.getElementById('due-date-from').value;
        const dueDateTo = document.getElementById('due-date-to').value;
        const status = document.getElementById('status-filter').value;

        try {
            const response = await fetch(`/task/filter?TaskType=${taskType}&Priority=${priority}&StartDate=${dueDateFrom}&EndDate=${dueDateTo}&Status=${status}`);
            if (response.ok) {
                const data = await response.json();
                renderTasks(data.tasks);
            } else {
                console.error('Failed to apply filters.');
            }
        } catch (error) {
            console.error('Error applying filters:', error);
        }
    });

    // Handle search input
    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        searchTasks(query);
    });

    async function searchTasks(query) {
        try {
            // If the search bar is empty, fetch all tasks with pagination
            const url = query.length > 0 
                ? `/task/search?name=${encodeURIComponent(query)}` 
                : `/task/search?pageNumber=1&pageSize=10`;
            const response = await fetch(url);
            if (response.ok) {
                const data = await response.json();
                renderTasks(data.tasks);
            } else {
                console.error('Failed to fetch search results.');
            }
        } catch (error) {
            console.error('Error fetching search results:', error);
        }
    }

    // Fetch tasks with sorting
    async function fetchSortedTasks(ascending) {
        try {
            const response = await fetch(`/task/sorted?ascending=${ascending}`);
            if (response.ok) {
                const data = await response.json();
                renderTasks(data.tasks);
            } else {
                console.error('Failed to fetch sorted tasks.');
            }
        } catch (error) {
            console.error('Error fetching sorted tasks:', error);
        }
    }

    // Render tasks in the table
    function renderTasks(tasks) {
        taskTableBody.innerHTML = '';

        if (tasks.length === 0) {
            taskTableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="py-3 md:py-4 px-4 md:px-6 text-center text-gray-500">No tasks available.</td>
                </tr>
            `;
            return;
        }

        tasks.forEach(task => {
            const row = `
                <tr class="text-sm md:text-base text-gray-700 hover:bg-gray-50 transition">
                    <td class="py-3 md:py-4 px-4 md:px-6"><input type="checkbox"></td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${task.taskID}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${task.taskTitle}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${task.taskType}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${task.assignedTo}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${task.priority}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${new Date(task.dueDate).toLocaleString()}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">
                        <span class="px-3 py-1 rounded-full text-sm md:text-base font-medium 
                            ${task.status.toLowerCase() === 'in progress' || task.status.toLowerCase() === 'in-progress' ? 'bg-green-100 text-green-700' : (task.status.toLowerCase() === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700')}">
                            ${task.status}
                        </span>
                    </td>   
                    <td class="py-3 md:py-4 px-4 md:px-6">
                        <div class="flex items-center space-x-2">
                            <x-archiveredicon class="w-5 h-5 text-blue-600 hover:text-blue-800" />
                            <button class="text-red-500 hover:underline">Archive</button>
                        </div>
                    </td>
                </tr>
            `;
            taskTableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    // Load all tasks when the page loads
    searchTasks('');
});
