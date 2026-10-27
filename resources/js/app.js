import './portfolio-motion.js';
import './project-gallery.js';
import './contact.js';
import './navigation.js';
import './active-section.js';
import './back-to-top.js';
import './project-search.js';

const motionReduced = window.matchMedia(
    "(prefers-reduced-motion: reduce)"
);

const catalog = [
    ...document.querySelectorAll("[data-project][data-category]"),
];

const savedKey = "lander.portfolio.saved.v1";

let saved = new Set();
let storageAvailable = true;
let currentFilter =
    document.querySelector(".archive")?.dataset.initialFilter || "all";
let query = "";
let toastTimer;

// Restore this browser's saved collection.
try {
    const stored = JSON.parse(localStorage.getItem(savedKey) || "[]");

    if (Array.isArray(stored)) {
        saved = new Set(
            stored.filter((id) => typeof id === "string")
        );
    }
} catch {
    storageAvailable = false;
}

// Notifications.
function notify(message) {
    const toast = document.querySelector(".toast");

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
    let visible = 0;

    for (const card of catalog) {
        const matchesCategory =
            currentFilter === "all" ||
            (
                currentFilter === "saved"
                    ? saved.has(card.dataset.project)
                    : card.dataset.category === currentFilter
            );

        const searchText = (
            card.dataset.search || card.textContent || ""
        ).toLowerCase();

        const matchesSearch = searchText.includes(query);

        card.hidden = !(matchesCategory && matchesSearch);

        if (!card.hidden) {
            visible++;
        }
    }

    document.querySelectorAll("[data-filter]").forEach((control) => {
        const selected = control.dataset.filter === currentFilter;

        control.classList.toggle("active", selected);

        if (control.tagName === "BUTTON") {
            control.setAttribute("aria-pressed", String(selected));
        } else if (selected) {
            control.setAttribute("aria-current", "true");
        } else {
            control.removeAttribute("aria-current");
        }
    });

    const count = document.querySelector("[data-result-count]");

    if (count) {
        count.textContent =
            `${visible} PROJECT${visible === 1 ? "" : "S"}`;
    }

    const empty = document.querySelector(".archive-empty");

    if (empty) {
        empty.hidden = visible > 0;
    }
}

// Synchronize save buttons and collection counts.
function syncSaved() {
    document.querySelectorAll("[data-save]").forEach((button) => {
        const id = button.dataset.save;
        const active = saved.has(id);
        const name = id.toUpperCase();

        button.setAttribute("aria-pressed", String(active));

        button.setAttribute(
            "aria-label",
            active
                ? `Remove ${name} from collection`
                : `Save ${name}`
        );

        button.textContent = active ? "✓" : "+";
    });

    document.querySelectorAll("[data-saved-count]").forEach((count) => {
        count.textContent = saved.size;
    });

    applyFilters();
}

// Save or remove a project.
document.querySelectorAll("[data-save]").forEach((button) => {
    button.addEventListener("click", () => {
        const id = button.dataset.save;

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

        syncSaved();

        const action = saved.has(id)
            ? "saved to"
            : "removed from";

        const storageMessage = storageAvailable
            ? ""
            : " Changes apply to this visit only.";

        notify(
            `${id.toUpperCase()} ${action} your collection.${storageMessage}`
        );
    });
});

// Category controls.
document.querySelectorAll("[data-filter]").forEach((control) => {
    control.addEventListener("click", (event) => {
        if (!catalog.length) return;

        event.preventDefault();

        currentFilter = control.dataset.filter;

        applyFilters();
    });
});

// Search within the active category.
document
    .querySelector('[aria-label="Find a project"]')
    ?.addEventListener("input", (event) => {
        query = event.target.value.trim().toLowerCase();

        applyFilters();
    });

// Open the visitor's collection.
document
    .querySelector("[data-open-saved]")
    ?.addEventListener("click", () => {
        currentFilter = "saved";
        query = "";

        const search = document.querySelector(
            '[aria-label="Find a project"]'
        );

        if (search) {
            search.value = "";
        }

        applyFilters();

        document.querySelector("#projects")?.scrollIntoView({
            behavior: motionReduced.matches ? "auto" : "smooth",
            block: "start",
        });

        document
            .querySelector('[data-filter="saved"]')
            ?.focus({ preventScroll: true });
    });

// Synchronize the collection across browser tabs.
window.addEventListener("storage", (event) => {
    if (event.key !== savedKey) return;

    try {
        const list = JSON.parse(event.newValue || "[]");

        saved = Array.isArray(list)
            ? new Set(list.filter((id) => typeof id === "string"))
            : new Set();
    } catch {
        saved = new Set();
    }

    syncSaved();
});

syncSaved();

// Showcase carousel.
const carousel = document.querySelector(".carousel");

if (carousel) {
    const cards = [
        ...carousel.querySelectorAll(".showcase-card"),
    ];

    const previous = document.querySelector(
        "[data-carousel-prev]"
    );

    const next = document.querySelector(
        "[data-carousel-next]"
    );

    const position = document.querySelector(
        ".carousel-position"
    );

    function updateCarousel() {
        const carouselLeft =
            carousel.getBoundingClientRect().left;

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
            const current = cards.length
                ? nearest.index + 1
                : 0;

            position.textContent =
                `${String(current).padStart(2, "0")} / ` +
                `${String(cards.length).padStart(2, "0")}`;
        }

        if (previous) {
            previous.disabled = carousel.scrollLeft < 5;
        }

        if (next) {
            next.disabled =
                carousel.scrollLeft + carousel.clientWidth >=
                carousel.scrollWidth - 5;
        }
    }

    function move(direction) {
        const cardWidth =
            cards[0]?.getBoundingClientRect().width || 300;

        const gap =
            parseFloat(getComputedStyle(carousel).columnGap) || 0;

        carousel.scrollBy({
            left: direction * (cardWidth + gap),
            behavior: motionReduced.matches ? "auto" : "smooth",
        });
    }

    previous?.addEventListener("click", () => move(-1));

    next?.addEventListener("click", () => move(1));

    carousel.addEventListener("keydown", (event) => {
        if (event.target !== carousel) return;

        if (
            event.key === "ArrowRight" ||
            event.key === "ArrowLeft"
        ) {
            event.preventDefault();

            move(event.key === "ArrowRight" ? 1 : -1);
        }
    });

    carousel.addEventListener(
        "scroll",
        updateCarousel,
        { passive: true }
    );

    window.addEventListener("resize", updateCarousel);

    updateCarousel();
}

// Project sharing dialog.
const shareDialog = document.querySelector(".share-dialog");

let shareOpener;

document.querySelectorAll("[data-share]").forEach((button) => {
    button.addEventListener("click", () => {
        if (!shareDialog) return;

        const field = shareDialog.querySelector("input");
        const heading = shareDialog.querySelector("h2");

        if (!field) return;

        shareOpener = button;

        field.value = new URL(
            button.dataset.share,
            window.location.href
        ).href;

        if (heading) {
            heading.textContent =
                `Share ${button.dataset.shareName || "this project"}`;
        }

        if (!shareDialog.open) {
            shareDialog.showModal();
        }

        field.focus();
        field.select();
    });
});

document
    .querySelector("[data-copy-share]")
    ?.addEventListener("click", async () => {
        const field = shareDialog?.querySelector("input");

        if (!field) return;

        try {
            await navigator.clipboard.writeText(field.value);

            shareDialog.close();

            notify("Project link copied. Ready to share.");
        } catch {
            field.focus();
            field.select();

            notify(
                "Select and copy the link with Ctrl+C or Command+C."
            );
        }
    });

document
    .querySelector("[data-close-share]")
    ?.addEventListener("click", () => {
        shareDialog?.close();
    });

shareDialog?.addEventListener("close", () => {
    shareOpener?.focus();
});

// Close when the visitor clicks outside the dialog.
shareDialog?.addEventListener("click", (event) => {
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

// Pointer-driven CSS 3D tilt.
const pointerFine = window.matchMedia("(pointer: fine)");

document
    .querySelectorAll(".hero-scene[data-tilt]")
    .forEach((scene) => {
        scene.addEventListener("pointermove", (event) => {
            if (
                motionReduced.matches ||
                !pointerFine.matches
            ) {
                return;
            }

            const rect = scene.getBoundingClientRect();

            if (!rect.width || !rect.height) return;

            const x =
                (event.clientX - rect.left) / rect.width - 0.5;

            const y =
                (event.clientY - rect.top) / rect.height - 0.5;

            scene.style.setProperty("--rx", `${-y * 12}deg`);
            scene.style.setProperty("--ry", `${x * 16}deg`);
        });

        scene.addEventListener("pointerleave", () => {
            scene.style.setProperty("--rx", "0deg");
            scene.style.setProperty("--ry", "0deg");
        });
    });

