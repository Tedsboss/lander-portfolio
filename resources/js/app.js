import './portfolio-motion.js';
import './project-gallery.js';
import './contact.js';
import './navigation.js';
import './active-section.js';
import './back-to-top.js';
import './project-search.js';
import './background-theme.js';
import './analytics.js';
import './archive-share.js';

// Shared settings.
const motionReduced = window.matchMedia(
    '(prefers-reduced-motion: reduce)'
);

const archive = document.querySelector('.archive');

const catalog = archive
    ? [...archive.querySelectorAll('[data-project][data-category]')]
    : [];

const searchInput = document.querySelector(
    '[aria-label="Find a project"]'
);

const filterControls = [
    ...document.querySelectorAll('[data-filter]'),
];

const savedKey = 'lander.portfolio.saved.v1';
const archiveStateKey = 'lander.portfolio.archive.v1';

const allowedArchiveFilters = new Set([
    'all',
    'saved',
    ...filterControls.map((control) => control.dataset.filter),
]);

let saved = new Set();
let storageAvailable = true;
let currentFilter = archive?.dataset.initialFilter || 'all';
let query = searchInput?.value.trim().toLowerCase() || '';
let toastTimer;

// Saved-project storage.
function parseSavedCollection(value) {
    const list = JSON.parse(value || '[]');

    return new Set(
        Array.isArray(list)
            ? list.filter((id) => typeof id === 'string')
            : []
    );
}

try {
    saved = parseSavedCollection(localStorage.getItem(savedKey));
} catch {
    storageAvailable = false;
}

// Remember archive selections and synchronize the address bar.
function saveArchiveState() {
    if (!archive) return;

    const search = searchInput?.value || '';

    try {
        sessionStorage.setItem(
            archiveStateKey,
            JSON.stringify({
                filter: currentFilter,
                search,
            })
        );
    } catch {
        // Filtering remains available without browser storage.
    }

    const url = new URL(window.location.href);

    url.searchParams.delete('category');
    url.searchParams.delete('collection');
    url.searchParams.delete('q');

    if (currentFilter === 'saved') {
        // "saved" is a browser collection, not a server category.
        url.searchParams.set('collection', 'saved');
    } else if (currentFilter !== 'all') {
        url.searchParams.set('category', currentFilter);
    }

    if (search.trim()) {
        url.searchParams.set('q', search.trim());
    }

    if (url.href !== window.location.href) {
        try {
            window.history.replaceState(
                window.history.state,
                '',
                url.href
            );
        } catch {
            // Filtering still works if the URL cannot be updated.
        }
    }
}

// Shared URLs take priority over remembered selections.
function restoreArchiveState() {
    if (!archive) return;

    const parameters = new URLSearchParams(window.location.search);

    const hasSharedSelection =
        parameters.has('category') ||
        parameters.has('collection') ||
        parameters.has('q');

    let restoredFilter = currentFilter;
    let restoredSearch = searchInput?.value || '';

    if (hasSharedSelection) {
        const category = parameters.get('category');

        if (
            category &&
            category !== 'saved' &&
            allowedArchiveFilters.has(category)
        ) {
            restoredFilter = category;
        } else if (parameters.get('collection') === 'saved') {
            restoredFilter = 'saved';
        } else {
            restoredFilter = 'all';
        }

        restoredSearch = parameters.get('q') || '';
    } else {
        try {
            const state = JSON.parse(
                sessionStorage.getItem(archiveStateKey) || 'null'
            );

            if (
                state &&
                typeof state === 'object' &&
                allowedArchiveFilters.has(state.filter) &&
                typeof state.search === 'string'
            ) {
                restoredFilter = state.filter;
                restoredSearch = state.search;
            }
        } catch {
            // Keep the normal initial state.
        }
    }

    currentFilter = restoredFilter;
    query = restoredSearch.trim().toLowerCase();

    if (searchInput) {
        searchInput.value = restoredSearch;

        searchInput.dispatchEvent(
            new Event('input', { bubbles: true })
        );
    }
}

// Notifications.
function notify(message) {
    const toast = document.querySelector('.toast');

    if (!toast) return;

    clearTimeout(toastTimer);

    toast.textContent = message;
    toast.hidden = false;

    toastTimer = setTimeout(() => {
        toast.hidden = true;
    }, 4000);
}

// Project archive filtering.
function applyFilters() {
    if (!archive) return;

    saveArchiveState();

    let visible = 0;

    for (const card of catalog) {
        const matchesCategory =
            currentFilter === 'all' ||
            (
                currentFilter === 'saved'
                    ? saved.has(card.dataset.project)
                    : card.dataset.category === currentFilter
            );

        const searchText = (
            card.dataset.search || card.textContent || ''
        ).toLowerCase();

        const matchesSearch = searchText.includes(query);

        card.hidden = !(matchesCategory && matchesSearch);

        if (!card.hidden) {
            visible++;
        }
    }

    filterControls.forEach((control) => {
        const selected = control.dataset.filter === currentFilter;

        control.classList.toggle('active', selected);

        if (control.tagName === 'BUTTON') {
            control.setAttribute('aria-pressed', String(selected));
        } else if (selected) {
            control.setAttribute('aria-current', 'true');
        } else {
            control.removeAttribute('aria-current');
        }
    });

    const count = archive.querySelector('[data-result-count]');

    if (count) {
        const message =
            `${visible} PROJECT${visible === 1 ? '' : 'S'}`;

        if (count.textContent.trim() !== message) {
            count.textContent = message;
        }
    }

    const empty = archive.querySelector('.archive-empty');

    if (empty) {
        empty.hidden = visible > 0;
    }
}

// Synchronize saved buttons and collection counts.
function syncSaved() {
    document.querySelectorAll('[data-save]').forEach((button) => {
        const id = button.dataset.save;

        if (!id) return;

        const active = saved.has(id);
        const name = id.toUpperCase();

        button.setAttribute('aria-pressed', String(active));

        button.setAttribute(
            'aria-label',
            active
                ? `Remove ${name} from collection`
                : `Save ${name}`
        );

        button.textContent = active ? '✓' : '+';
    });

    document.querySelectorAll('[data-saved-count]').forEach((count) => {
        count.textContent = String(saved.size);
    });

    applyFilters();
}

// Save or remove a project.
document.querySelectorAll('[data-save]').forEach((button) => {
    button.addEventListener('click', () => {
        const id = button.dataset.save;

        if (!id) return;

        if (saved.has(id)) {
            saved.delete(id);
        } else {
            saved.add(id);
        }

        try {
            localStorage.setItem(
                savedKey,
                JSON.stringify([...saved])
            );

            storageAvailable = true;
        } catch {
            storageAvailable = false;
        }

        // Avoid leaving keyboard focus inside a row being hidden.
        const row = button.closest(
            '.archive [data-project][data-category]'
        );

        if (
            currentFilter === 'saved' &&
            !saved.has(id) &&
            row?.contains(document.activeElement)
        ) {
            document
                .querySelector('[data-filter="saved"]')
                ?.focus({ preventScroll: true });
        }

        syncSaved();

        const action = saved.has(id)
            ? 'saved to'
            : 'removed from';

        const storageMessage = storageAvailable
            ? ''
            : ' Changes apply to this visit only.';

        notify(
            `${id.toUpperCase()} ${action} your collection.${storageMessage}`
        );
    });
});

// Category controls.
filterControls.forEach((control) => {
    control.addEventListener('click', (event) => {
        if (!archive) return;

        if (
            control.tagName === 'A' &&
            (
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey
            )
        ) {
            return;
        }

        event.preventDefault();

        const filter = control.dataset.filter;

        currentFilter = allowedArchiveFilters.has(filter)
            ? filter
            : 'all';

        applyFilters();
    });
});

// Search within the active category.
// Shortcuts and the clear button live in project-search.js.
searchInput?.addEventListener('input', () => {
    query = searchInput.value.trim().toLowerCase();

    applyFilters();
});

function clearSearchInput() {
    query = '';

    if (!searchInput) {
        applyFilters();
        return;
    }

    searchInput.value = '';

    searchInput.dispatchEvent(
        new Event('input', { bubbles: true })
    );
}

// Open the visitor's saved collection.
document.querySelectorAll('[data-open-saved]').forEach((button) => {
    button.addEventListener('click', () => {
        if (!archive) return;

        currentFilter = 'saved';

        clearSearchInput();

        archive.scrollIntoView({
            behavior: motionReduced.matches ? 'instant' : 'smooth',
            block: 'start',
        });

        document
            .querySelector('[data-filter="saved"]')
            ?.focus({ preventScroll: true });
    });
});

// Reset an empty search to all projects.
document
    .querySelector('[data-reset-project-search]')
    ?.addEventListener('click', () => {
        if (!archive) return;

        currentFilter = 'all';

        const focusTarget =
            searchInput ||
            document.querySelector('[data-filter="all"]');

        focusTarget?.focus({ preventScroll: true });

        clearSearchInput();
    });

// Synchronize the saved collection between browser tabs.
window.addEventListener('storage', (event) => {
    if (event.key !== savedKey && event.key !== null) return;

    try {
        saved = parseSavedCollection(
            event.key === null ? null : event.newValue
        );
    } catch {
        saved = new Set();
    }

    syncSaved();
});

// Restore archive selections before displaying initial results.
restoreArchiveState();
syncSaved();

// Refresh state when returning through the browser's page cache.
window.addEventListener('pageshow', (event) => {
    if (!event.persisted) return;

    try {
        saved = parseSavedCollection(localStorage.getItem(savedKey));
    } catch {
        // Preserve the collection held in memory.
    }

    restoreArchiveState();
    syncSaved();
});

// Showcase carousel.
const carousel = document.querySelector('.carousel');

if (carousel) {
    const cards = [
        ...carousel.querySelectorAll('.showcase-card'),
    ];

    const previous = document.querySelector('[data-carousel-prev]');
    const next = document.querySelector('[data-carousel-next]');
    const position = document.querySelector('.carousel-position');

    let carouselFrame = 0;

    function updateCarousel() {
        carouselFrame = 0;

        const carouselLeft = carousel.getBoundingClientRect().left;

        const nearest = cards.reduce(
            (best, card, index) => {
                const distance = Math.abs(
                    card.getBoundingClientRect().left - carouselLeft
                );

                return distance < best.distance
                    ? { distance, index }
                    : best;
            },
            { distance: Infinity, index: 0 }
        );

        if (position) {
            const current = cards.length ? nearest.index + 1 : 0;

            const message =
                `${String(current).padStart(2, '0')} / ` +
                `${String(cards.length).padStart(2, '0')}`;

            if (position.textContent.trim() !== message) {
                position.textContent = message;
            }
        }

        const maxScroll = Math.max(
            0,
            carousel.scrollWidth - carousel.clientWidth
        );

        if (previous) {
            previous.disabled =
                !cards.length || carousel.scrollLeft <= 5;
        }

        if (next) {
            next.disabled =
                !cards.length || carousel.scrollLeft >= maxScroll - 5;
        }
    }

    function scheduleCarouselUpdate() {
        if (carouselFrame) return;

        carouselFrame = requestAnimationFrame(updateCarousel);
    }

    function move(direction) {
        if (!cards.length) return;

        const cardWidth = cards[0].getBoundingClientRect().width;

        const gap =
            parseFloat(getComputedStyle(carousel).columnGap) || 0;

        carousel.scrollBy({
            left: direction * (cardWidth + gap),
            behavior: motionReduced.matches ? 'instant' : 'smooth',
        });
    }

    previous?.addEventListener('click', () => move(-1));
    next?.addEventListener('click', () => move(1));

    carousel.addEventListener('keydown', (event) => {
        if (event.target !== carousel) return;

        if (
            event.key === 'ArrowRight' ||
            event.key === 'ArrowLeft'
        ) {
            event.preventDefault();

            move(event.key === 'ArrowRight' ? 1 : -1);
        }
    });

    carousel.addEventListener('scroll', scheduleCarouselUpdate, {
        passive: true,
    });

    window.addEventListener('resize', scheduleCarouselUpdate, {
        passive: true,
    });

    window.addEventListener('load', scheduleCarouselUpdate);
    window.addEventListener('pageshow', scheduleCarouselUpdate);

    if ('ResizeObserver' in window) {
        const observer = new ResizeObserver(scheduleCarouselUpdate);

        observer.observe(carousel);

        cards.forEach((card) => observer.observe(card));
    }

    updateCarousel();
}

// Native sharing with a copy-link dialog fallback.
const shareDialog = document.querySelector('.share-dialog');

let shareOpener;
let nativeSharePending = false;

document.querySelectorAll('[data-share]').forEach((button) => {
    button.addEventListener('click', async () => {
        if (!button.dataset.share || nativeSharePending) return;

        let shareUrl;

        try {
            shareUrl = new URL(
                button.dataset.share,
                window.location.href
            );

            if (!['https:', 'http:'].includes(shareUrl.protocol)) {
                throw new Error('Unsupported link');
            }
        } catch {
            notify('The project link could not be opened.');
            return;
        }

        const name = button.dataset.shareName || 'this project';

        if (
            window.isSecureContext &&
            typeof navigator.share === 'function'
        ) {
            nativeSharePending = true;

            try {
                await navigator.share({
                    title: `${name} — Lander`,
                    text: `Explore ${name} in Lander’s project portfolio.`,
                    url: shareUrl.href,
                });

                return;
            } catch (error) {
                if (error?.name === 'AbortError') {
                    return;
                }

                // Other failures use the copy-link dialog.
            } finally {
                nativeSharePending = false;
            }
        }

        const field = shareDialog?.querySelector('input');
        const heading = shareDialog?.querySelector('h2');

        if (!shareDialog || !field) {
            notify('Sharing is currently unavailable.');
            return;
        }

        shareOpener = button;
        field.value = shareUrl.href;

        if (heading) {
            heading.textContent = `Share ${name}`;
        }

        if (!shareDialog.open) {
            shareDialog.showModal();
        }

        field.focus();
        field.select();
    });
});

document
    .querySelector('[data-copy-share]')
    ?.addEventListener('click', async () => {
        const field = shareDialog?.querySelector('input');

        if (!field) return;

        try {
            await navigator.clipboard.writeText(field.value);

            shareDialog.close();

            notify('Project link copied. Ready to share.');
        } catch {
            field.focus();
            field.select();

            notify(
                'Select and copy the link with Ctrl+C or Command+C.'
            );
        }
    });

document
    .querySelector('[data-close-share]')
    ?.addEventListener('click', () => {
        shareDialog?.close();
    });

shareDialog?.addEventListener('close', () => {
    shareOpener?.focus({ preventScroll: true });
});

shareDialog?.addEventListener('click', (event) => {
    if (event.target !== shareDialog) return;

    const rect = shareDialog.getBoundingClientRect();

    const outside =
        event.clientX < rect.left ||
        event.clientX > rect.right ||
        event.clientY < rect.top ||
        event.clientY > rect.bottom;

    if (outside) {
        shareDialog.close();
    }
});

// Legacy hero-scene tilt, when that scene is present.
const pointerFine = window.matchMedia('(pointer: fine)');

document.querySelectorAll('.hero-scene[data-tilt]').forEach((scene) => {
    function resetTilt() {
        scene.style.setProperty('--rx', '0deg');
        scene.style.setProperty('--ry', '0deg');
    }

    scene.addEventListener('pointermove', (event) => {
        const motionPaused =
            document.documentElement.dataset.p4d === 'paused';

        if (
            motionReduced.matches ||
            !pointerFine.matches ||
            motionPaused
        ) {
            resetTilt();
            return;
        }

        const rect = scene.getBoundingClientRect();

        if (!rect.width || !rect.height) return;

        const x = (event.clientX - rect.left) / rect.width - 0.5;
        const y = (event.clientY - rect.top) / rect.height - 0.5;

        scene.style.setProperty('--rx', `${-y * 12}deg`);
        scene.style.setProperty('--ry', `${x * 16}deg`);
    });

    scene.addEventListener('pointerleave', resetTilt);
    scene.addEventListener('pointercancel', resetTilt);

    motionReduced.addEventListener('change', resetTilt);
});
