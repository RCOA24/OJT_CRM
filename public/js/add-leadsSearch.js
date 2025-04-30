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
            const response = await fetch(`http://192.168.1.9:2030/api/Leads/search-lead?name=${encodeURIComponent(query)}`, {
                headers: {
                    'Authorization': 'YRPP4vws97S&BI!#$R9s-)U(Bi-A?hwJKg_#qEeg.DRA/tk:.gva<)BA@<2~hI&P',
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const leads = await response.json();
                if (Array.isArray(leads) && leads.length > 0) {
                    leads.forEach(lead => {
                        const resultItem = document.createElement('div');
                        resultItem.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-xs';
                        resultItem.textContent = lead.fullName;
                        resultItem.addEventListener('click', () => {
                            populateLeadInputs(lead);
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

function sanitizeValue(val) {
    // Convert "N/A", null, or undefined to empty string
    return (val === "N/A" || val === null || val === undefined) ? "" : val;
}

function populateLeadInputs(lead) {
    // Remove readonly if set
    ['fullNameInput', 'emailInput', 'phoneNumberInput', 'companyNameInput', 'industryInput', 'leadSourceInput', 'statusInput'].forEach(id => {
        const input = document.getElementById(id);
        if (input) input.removeAttribute('readonly');
    });

    document.getElementById('fullNameInput').value = sanitizeValue(lead.fullName);
    document.getElementById('emailInput').value = sanitizeValue(lead.email);
    document.getElementById('phoneNumberInput').value = sanitizeValue(lead.phoneNumber);
    document.getElementById('companyNameInput').value = sanitizeValue(lead.companyName);
    // Use industry from companyDetails if available
    document.getElementById('industryInput').value = sanitizeValue(
        (lead.companyDetails && lead.companyDetails.industryType) ? lead.companyDetails.industryType : lead.industry
    );
    document.getElementById('leadSourceInput').value = sanitizeValue(lead.leadSource);
    document.getElementById('statusInput').value = sanitizeValue(lead.status);
    document.getElementById('clientIDInput').value = sanitizeValue(lead.clientID || lead.clientId);

    if (lead.deals) {
        document.getElementById('dealNameInput').value = sanitizeValue(lead.deals.dealName);
        document.getElementById('assignedSalesRepInput').value = sanitizeValue(lead.deals.assignedSalesRep);
        document.getElementById('dealValueInput').value = sanitizeValue(lead.deals.dealValue);
        document.getElementById('currencyInput').value = sanitizeValue(lead.deals.currency);
        document.getElementById('stageInput').value = sanitizeValue(lead.deals.stage);
        document.getElementById('dealStatusInput').value = sanitizeValue(lead.deals.status);
    }
    if (lead.payment) {
        document.getElementById('paymentTermsInput').value = sanitizeValue(lead.payment.paymentTerms);
        document.getElementById('discountsInput').value = sanitizeValue(lead.payment.discount);
        document.getElementById('estimatedValueInput').value = sanitizeValue(lead.payment.estimatedValue);
        document.getElementById('finalPriceInput').value = sanitizeValue(lead.payment.finalPrice);
        document.getElementById('invoiceNumberInput').value = sanitizeValue(lead.payment.invoiceNumber);
        document.getElementById('paymentStatusInput').value = sanitizeValue(lead.payment.paymentStatus);
    }
}

