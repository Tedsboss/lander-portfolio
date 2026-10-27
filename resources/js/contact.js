document.querySelectorAll('[data-copy-email]').forEach((button) => {
    const statusId = button.getAttribute('aria-describedby');
    const status = document.getElementById(statusId);

    button.addEventListener('click', async () => {
        const email = button.dataset.copyEmail;

        if (!email) return;

        button.disabled = true;

        if (status) {
            status.textContent = '';
        }

        try {
            if (!navigator.clipboard?.writeText) {
                throw new Error('Clipboard unavailable');
            }

            await navigator.clipboard.writeText(email);

            if (status) {
                status.textContent = 'Email address copied.';
            }
        } catch {
            if (status) {
                status.textContent =
                    'Please select and copy the email address shown above.';
            }
        } finally {
            button.disabled = false;
        }
    });
});
