document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const leadTableBody = document.getElementById('lead-table-body');

    function renderLeads(leads) {
        leadTableBody.innerHTML = '';
        if (!leads || leads.length === 0) {
            leadTableBody.innerHTML = `
                <tr>
                    <td colspan="10" class="py-3 md:py-4 px-4 md:px-6 text-center text-gray-500">No leads available.</td>
                </tr>
            `;
            return;
        }
        leads.forEach(lead => {
            leadTableBody.insertAdjacentHTML('beforeend', `
                <tr class="text-sm md:text-base text-[#444444] hover:bg-gray-200 transition duration-200 ease-in-out">
                    <td class="py-3 md:py-4 px-4 md:px-6"><input type="checkbox"></td>
                    <td class="py-3 md:py-4 px-4 md:px-6">
                        <a href="/leads/${lead.leadId || ''}" class="text-blue-500 hover:underline">
                            ${lead.fullName || 'N/A'}
                        </a>
                    </td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.email || 'N/A'}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.phoneNumber || 'N/A'}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.companyName || 'N/A'}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.industry || 'N/A'}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.deals?.dealName || 'N/A'}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.deals?.stage || 'N/A'}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.deals?.assignedSalesRep || 'N/A'}</td>
                    <td class="py-3 md:py-4 px-4 md:px-6">${lead.dateCreated ? (new Date(lead.dateCreated)).toISOString().slice(0,10) : 'N/A'}</td>
                </tr>
            `);
        });
    }

    async function handleLeadSearch() {
        const query = searchInput.value.trim();
        try {
            let url;
            if (query.length > 0) {
                url = `http://192.168.1.9:2030/api/Leads/search-lead?name=${encodeURIComponent(query)}`;
            } else {
                url = `http://192.168.1.9:2030/api/Leads/all-leads?pageNumber=1&pageSize=100`;
            }

            const response = await fetch(url, {
                headers: {
                    'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                    'Accept': 'application/json',
                }
            });

            if (response.ok) {
                const data = await response.json();
                const leads = Array.isArray(data) ? data : (data.items || []);
                renderLeads(leads);
            } else {
                renderLeads([]);
            }
        } catch (error) {
            renderLeads([]);
        }
    }

    searchInput.addEventListener('input', handleLeadSearch);
});