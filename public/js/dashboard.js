document.addEventListener('DOMContentLoaded', async () => {
    const totalClientsCount = document.getElementById('total-clients-count');
    const totalUsersCount = document.getElementById('total-users-count');
    const pendingTasksCount = document.getElementById('pending-tasks-count');
    const countsApiUrl = '/dashboard/get-counts'; // Endpoint to fetch counts

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

            // Update the counts dynamically
            if (totalClientsCount) totalClientsCount.textContent = data.totalClients ?? '0';
            if (totalUsersCount) totalUsersCount.textContent = data.totalUsers ?? '0';
            if (pendingTasksCount) pendingTasksCount.textContent = data.totalPendingTasks ?? '0';
        } catch (error) {
            console.error('Error fetching counts:', error);
            if (totalClientsCount) totalClientsCount.textContent = 'Error';
            if (totalUsersCount) totalUsersCount.textContent = 'Error';
            if (pendingTasksCount) pendingTasksCount.textContent = 'Error';
        }
    }

    // Fetch counts initially and then every 10 seconds
    await fetchCounts();
    setInterval(fetchCounts, 10000);
});
