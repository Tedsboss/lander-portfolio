const copyViewButton = document.querySelector(
    '[data-copy-archive-link]'
);

if (copyViewButton) {
    const status = document.querySelector(
        '[data-archive-share-status]'
    );

    const fallback = document.querySelector(
        '[data-archive-share-fallback]'
    );

    copyViewButton.addEventListener('click', async () => {
        const url = new URL(window.location.href);

        url.hash = 'projects';

        copyViewButton.disabled = true;

        if (status) {
            status.textContent = '';
        }

        if (fallback) {
            fallback.hidden = true;
        }

        try {
            if (!navigator.clipboard?.writeText) {
                throw new Error('Clipboard unavailable');
            }

            await navigator.clipboard.writeText(url.href);

            if (status) {
                status.textContent = 'View link copied.';
            }
        } catch {
            if (fallback) {
                fallback.value = url.href;
                fallback.hidden = false;
                fallback.focus();
                fallback.select();
            }

            if (status) {
                status.textContent =
                    'Select and copy the link below.';
            }
        } finally {
            copyViewButton.disabled = false;
        }
    });
}
