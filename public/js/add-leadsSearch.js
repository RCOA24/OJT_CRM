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
            // Use the correct client search endpoint
            const response = await fetch(`http://192.168.1.9:2030/api/Clients/search-client?name=${encodeURIComponent(query)}`, {
                headers: {
                    'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const clients = await response.json();
                if (Array.isArray(clients) && clients.length > 0) {
                    clients.forEach(client => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-xs';
                        resultItem.textContent = client.fullName;
                        resultItem.addEventListener('click', () => {
                            populateLeadInputs(client);
                            resultsContainer.classList.add('hidden');
                        });
                        resultsContainer.appendChild(resultItem);
                    });
                    resultsContainer.classList.remove('hidden');
                }
            }
        } catch (error) {
            console.error('Error fetching clients:', error);
        }
    }
});

function sanitizeValue(val) {
    // Convert "N/A", null, or undefined to empty string
    return (val === "N/A" || val === null || val === undefined) ? "" : val;
}

function populateLeadInputs(client) {
    console.log('Client object:', client); // Debug: See what data is received

    // Defensive: check if element exists before setting value
    const setVal = (id, val) => {
        const el = document.getElementById(id);
        if (el) el.value = sanitizeValue(val);
    };

    setVal('fullNameInput', client.fullName);
    setVal('emailInput', client.email);
    setVal('phoneNumberInput', client.phoneNumber);
    setVal('companyNameInput', client.companyName);

    // Get industryType from companyDetails
    let industryVal = "";
    if (client.companyDetails && client.companyDetails.industryType) {
        industryVal = client.companyDetails.industryType;
    }
    setVal('industryInput', industryVal);

    // Set clientID hidden input
    setVal('clientIDInput', client.clientId);
}

