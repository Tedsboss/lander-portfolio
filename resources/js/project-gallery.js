import '../css/project-gallery.css';

function initializeProjectGalleries() {
    document.querySelectorAll('[data-project-gallery]').forEach((gallery) => {
        if (gallery.dataset.initialized === 'true') return;
        gallery.dataset.initialized = 'true';

        const shots = [
            ...gallery.querySelectorAll('[data-gallery-shot]'),
        ];

        const mainImage = gallery.querySelector('[data-gallery-image]');
        const mainCaption = gallery.querySelector('[data-gallery-caption]');
        const opener = gallery.querySelector('[data-gallery-open]');
        const dialog = gallery.querySelector('[data-project-lightbox]');
        const viewerImage = gallery.querySelector('[data-lightbox-image]');
        const viewerCaption = gallery.querySelector('[data-lightbox-caption]');
        const counter = gallery.querySelector('[data-lightbox-count]');
        const previous = gallery.querySelector('[data-lightbox-prev]');
        const next = gallery.querySelector('[data-lightbox-next]');
        const close = gallery.querySelector('[data-lightbox-close]');

        if (!shots.length || !mainImage || !dialog) return;

        const projectName = gallery.dataset.projectName || 'Project';
        let index = 0;

        function select(value) {
            index = Math.max(0, Math.min(shots.length - 1, value));

            const shot = shots[index];
            const caption = shot.dataset.caption || 'Screenshot';
            const description = `${projectName} — ${caption}`;

            mainImage.src = shot.href;
            mainImage.alt = description;
            mainCaption.textContent = caption;

            opener.href = shot.href;
            opener.setAttribute('aria-label', `Enlarge ${description}`);

            shots.forEach((link, position) => {
                if (position === index) {
                    link.setAttribute('aria-current', 'true');
                } else {
                    link.removeAttribute('aria-current');
                }
            });

            if (dialog.open) {
                viewerImage.src = shot.href;
                viewerImage.alt = description;
                viewerCaption.textContent = description;
            }

            counter.textContent = `${index + 1} / ${shots.length}`;
            previous.disabled = index === 0;
            next.disabled = index === shots.length - 1;
        }

        shots.forEach((shot, position) => {
            shot.addEventListener('click', (event) => {
                // Preserve opening an image in a new tab with modifier keys.
                if (
                    event.ctrlKey ||
                    event.metaKey ||
                    event.shiftKey ||
                    event.altKey
                ) {
                    return;
                }

                event.preventDefault();
                select(position);
            });
        });

        opener.addEventListener('click', (event) => {
            if (
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey ||
                typeof dialog.showModal !== 'function'
            ) {
                return;
            }

            event.preventDefault();
            dialog.showModal();
            select(index);
        });

        previous.addEventListener('click', () => select(index - 1));
        next.addEventListener('click', () => select(index + 1));
        close.addEventListener('click', () => dialog.close());

        dialog.addEventListener('keydown', (event) => {
            if (event.altKey || event.ctrlKey || event.metaKey) return;

            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                select(index - 1);
            }

            if (event.key === 'ArrowRight') {
                event.preventDefault();
                select(index + 1);
            }
        });

        dialog.addEventListener('click', (event) => {
            if (event.target !== dialog) return;

            const rect = dialog.getBoundingClientRect();

            if (
                event.clientX < rect.left ||
                event.clientX > rect.right ||
                event.clientY < rect.top ||
                event.clientY > rect.bottom
            ) {
                dialog.close();
            }
        });

        dialog.addEventListener('close', () => {
            opener.focus({ preventScroll: true });
        });

        select(0);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initializeProjectGalleries,
        { once: true }
    );
} else {
    initializeProjectGalleries();
}
