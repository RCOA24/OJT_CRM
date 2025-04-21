function toggleEditMode() {
    // Toggle regular fields
    document.querySelectorAll('[id$="Label"]').forEach(el => el.classList.toggle('hidden'));
    document.querySelectorAll('[id$="Input"]').forEach(el => el.classList.toggle('hidden'));

    // Toggle indexed fields for contact person section
    const contactFields = ['contactName', 'jobTitle', 'department', 'directEmail', 'directPhone'];

    // Make sure to adjust the max index based on how many contact persons you have
    const maxContactIndex = document.querySelectorAll('[id^="contactNameLabel"]').length - 1;

    for (let i = 0; i <= maxContactIndex; i++) {
        contactFields.forEach(field => {
            document.getElementById(`${field}Label${i}`).classList.toggle('hidden');
            document.getElementById(`${field}Input${i}`).classList.toggle('hidden');
        });
    }

    document.getElementById('saveButton').classList.toggle('hidden');
}
