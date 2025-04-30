function toggleEditMode() {
    document.querySelectorAll('input[id$="Input"]').forEach(input => {
        input.toggleAttribute('readonly');
        input.classList.toggle('bg-gray-50');
        input.classList.toggle('bg-white');
    });
    document.getElementById('saveButton').classList.toggle('hidden');
}

document.getElementById('search-input').addEventListener('input', async function () {
    const query = this.value.trim();
    const resultsContainer = document.getElementById('search-results');
    resultsContainer.innerHTML = '';
    resultsContainer.classList.add('hidden');

    if (query.length > 2) {
        try {
            const response = await fetch(`http://192.168.1.9:2030/api/Leads/search-lead?name=${query}`, {
                headers: {
                    'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const leads = await response.json();
                if (leads.length > 0) {
                    leads.forEach(lead => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                        resultItem.textContent = lead.fullName;
                        resultItem.addEventListener('click', () => {
                            populateLeadDetails(lead);
                            resultsContainer.classList.add('hidden');
                        });
                        resultsContainer.appendChild(resultItem);
                    });
                    resultsContainer.classList.remove('hidden');
                }
            }
        } catch (error) {
            console.error('Error fetching leads:', error);
        }
    }
});

function populateLeadDetails(lead) {
    // Update form action to point to the selected lead's update endpoint
    const editForm = document.getElementById('edit-lead-form');
    editForm.action = `/leads/${lead.leadId}`;

    // Populate the input fields with the selected lead's details
    document.getElementById('fullNameInput').value = lead.fullName || '';
    document.getElementById('emailInput').value = lead.email || '';
    document.getElementById('phoneNumberInput').value = lead.phoneNumber || '';
    document.getElementById('companyNameInput').value = lead.companyName || '';
    document.getElementById('industryInput').value = lead.industry || '';
    document.getElementById('leadSourceInput').value = lead.leadSource || '';
    document.getElementById('statusInput').value = lead.status || '';

    // Ensure fields are editable after clicking "Edit"
    toggleEditMode();
}

