document.addEventListener('DOMContentLoaded', async () => {
    const totalClientsCount = document.getElementById('total-clients-count');
    const totalUsersCount = document.getElementById('total-users-count');
    const pendingTasksCount = document.getElementById('pending-tasks-count');
    const totalLeadsCount = document.getElementById('total-leads-count'); // New element for total leads
    const countsApiUrl = '/dashboard/get-counts'; // Endpoint to fetch counts
    const leadsApiUrl = 'http://192.168.1.9:2030/api/Leads/all-leads'; // Corrected API URL for leads

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

    async function fetchLeadsCount() {
        try {
            const response = await fetch(`${leadsApiUrl}?pageNumber=1&pageSize=1`, {
                headers: {
                    'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P', // Added Authorization header
                    'Cache-Control': 'no-cache', // Ensure fresh data
                    'Pragma': 'no-cache',
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            // Debugging: Log the fetched leads data
            console.log('Fetched Leads:', data);

            // Update the total leads count dynamically
            if (totalLeadsCount) totalLeadsCount.textContent = data.totalRecords ?? '0'; // Use totalRecords for count
        } catch (error) {
            console.error('Error fetching leads count:', error);
            if (totalLeadsCount) totalLeadsCount.textContent = 'Error';
        }
    }

    // Fetch counts and leads initially and then every 10 seconds
    await fetchCounts();
    await fetchLeadsCount();
    setInterval(fetchCounts, 10000);
    setInterval(fetchLeadsCount, 10000);
});
