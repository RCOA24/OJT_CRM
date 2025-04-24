document.addEventListener('DOMContentLoaded', () => {
    const flashMessage = document.getElementById('flash-message');
    const closeFlashButton = document.getElementById('close-flash');

    if (flashMessage && closeFlashButton) {
        closeFlashButton.addEventListener('click', () => {
            flashMessage.style.opacity = '0';
            flashMessage.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                flashMessage.remove();
            }, 300); // Matches the CSS transition duration
        });

        // Auto-hide flash message after 5 seconds
        setTimeout(() => {
            if (flashMessage) {
                flashMessage.style.opacity = '0';
                flashMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    flashMessage.remove();
                }, 300);
            }
        }, 5000);
    }
});
