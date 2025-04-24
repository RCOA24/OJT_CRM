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
    sortButton.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent event from propagating to the document
        sortDropdown.classList.toggle('hidden');
        filterDropdown.classList.add('hidden'); // Ensure filter dropdown is closed
    });

    // Toggle filter dropdown visibility
    filterButton.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevent event from propagating to the document
        filterDropdown.classList.toggle('hidden');
        sortDropdown.classList.add('hidden'); // Ensure sort dropdown is closed
    });

    // Close both dropdowns when clicking outside
    document.addEventListener('click', () => {
        sortDropdown.classList.add('hidden');
        filterDropdown.classList.add('hidden');
    });

    // Prevent dropdowns from closing when clicking inside them
    sortDropdown.addEventListener('click', (event) => {
        event.stopPropagation();
    });

    filterDropdown.addEventListener('click', (event) => {
        event.stopPropagation();
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

    // Handle "Archive" button clicks
    taskTableBody.addEventListener('click', async (event) => {
        if (event.target.classList.contains('archive-button')) {
            const taskId = event.target.dataset.taskId;

            if (confirm('Are you sure you want to archive this task?')) {
                try {
                    const response = await fetch(`http://192.168.1.9:2030/api/Task/is-archive-task?isArchived=true&taskId=${taskId}`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                            'Accept': 'application/json',
                        },
                    });

                    if (response.ok) {
                        const result = await response.json();
                        alert(result.message || 'Task archived successfully.');
                        // Optionally, reload the tasks or remove the archived task from the table
                        searchTasks('');
                    } else {
                        alert('Failed to archive the task.');
                    }
                } catch (error) {
                    console.error('Error archiving task:', error);
                    alert('An error occurred while archiving the task.');
                }
            }
        }
    });

    // Handle filter application
    applyFiltersButton.addEventListener('click', async () => {
        const taskType = document.getElementById('task-type-filter').value;
        const priority = document.getElementById('priority-filter').value;
        const dueDateFrom = document.getElementById('due-date-from').value;
        const dueDateTo = document.getElementById('due-date-to').value;
        const status = document.getElementById('status-filter').value;

        // Build query parameters dynamically, excluding empty values
        const queryParams = new URLSearchParams();
        if (taskType) queryParams.append('TaskType', taskType);
        if (priority) queryParams.append('Priority', priority);
        if (dueDateFrom) queryParams.append('StartDate', dueDateFrom);
        if (dueDateTo) queryParams.append('EndDate', dueDateTo);
        if (status) queryParams.append('Status', status);

        try {
            const response = await fetch(`/task/filter?${queryParams.toString()}`);
            if (response.ok) {
                const data = await response.json();
                renderTasks(data.tasks);

                // Show flash message with selected filter criteria
                const appliedFilters = [];
                if (taskType) appliedFilters.push(`Task Type: ${taskType}`);
                if (priority) appliedFilters.push(`Priority: ${priority}`);
                if (dueDateFrom) appliedFilters.push(`Start Date: ${dueDateFrom}`);
                if (dueDateTo) appliedFilters.push(`End Date: ${dueDateTo}`);
                if (status) appliedFilters.push(`Status: ${status}`);

                flashMessageText.textContent = appliedFilters.length > 0
                    ? `Filters applied: ${appliedFilters.join(', ')}`
                    : 'No filters applied.';
                flashMessage.classList.remove('hidden');
                setTimeout(() => {
                    flashMessage.classList.add('hidden');
                }, 3000); // Hide after 3 seconds
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
            const response = await fetch(`/task/search?name=${encodeURIComponent(query)}`);
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
                            <button class="archive-button text-red-500 hover:underline" data-task-id="${task.taskID}">Archive</button>
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
