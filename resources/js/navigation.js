const header = document.querySelector('[data-portfolio-header]');
const toggle = header?.querySelector('[data-nav-toggle]');
const panel = header?.querySelector('[data-nav-panel]');

if (header && toggle && panel && !header.dataset.navReady) {
    const mobile = window.matchMedia('(max-width: 900px)');
    const icon = toggle.querySelector('[data-nav-icon]');

    function isOpen() {
        return header.dataset.navOpen === 'true';
    }

    function setOpen(open, restoreFocus = false) {
        const expanded = mobile.matches && open;

        // Move focus before making the panel inert.
        if (restoreFocus && mobile.matches) {
            toggle.focus({ preventScroll: true });
        }

        header.dataset.navOpen = String(expanded);

        toggle.setAttribute('aria-expanded', String(expanded));

        toggle.setAttribute(
            'aria-label',
            expanded ? 'Close navigation' : 'Open navigation'
        );

        if (icon) {
            icon.textContent = expanded ? '×' : '☰';
        }

        // Closed mobile links cannot receive keyboard focus.
        panel.inert = mobile.matches && !expanded;
    }

    function synchronizeLayout() {
        const focusedElement = document.activeElement;

        toggle.hidden = !mobile.matches;

        if (mobile.matches) {
            setOpen(false, panel.contains(focusedElement));
        } else {
            setOpen(false);

            if (focusedElement === toggle) {
                panel.querySelector('a')?.focus({
                    preventScroll: true,
                });
            }
        }
    }

    header.dataset.navReady = 'true';
    synchronizeLayout();

    toggle.addEventListener('click', () => {
        setOpen(!isOpen());
    });

    panel.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', (event) => {
            if (!mobile.matches || !isOpen()) return;

            setOpen(false, true);

            const modifiedClick =
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey;

            if (
                modifiedClick ||
                event.defaultPrevented ||
                link.hasAttribute('download') ||
                link.target === '_blank'
            ) {
                return;
            }

            const destination = new URL(link.href, window.location.href);

            const samePage =
                destination.origin === window.location.origin &&
                destination.pathname === window.location.pathname &&
                destination.search === window.location.search;

            if (!samePage || !destination.hash) return;

            let target;

            try {
                target = document.getElementById(
                    decodeURIComponent(destination.hash.slice(1))
                );
            } catch {
                return;
            }

            if (!target) return;

            // Let the browser handle anchor scrolling.
            // Move keyboard focus to the selected section.
            requestAnimationFrame(() => {
                if (!target.hasAttribute('tabindex')) {
                    target.setAttribute('tabindex', '-1');
                }

                target.focus({ preventScroll: true });
            });
        });
    });

    document.addEventListener('keydown', (event) => {
        if (
            event.key !== 'Escape' ||
            event.defaultPrevented ||
            !isOpen()
        ) {
            return;
        }

        event.preventDefault();
        setOpen(false, true);
    });

    document.addEventListener('click', (event) => {
        if (!isOpen() || header.contains(event.target)) return;

        setOpen(
            false,
            panel.contains(document.activeElement)
        );
    });

    header.addEventListener('focusout', () => {
        requestAnimationFrame(() => {
            if (
                isOpen() &&
                !header.contains(document.activeElement)
            ) {
                setOpen(false);
            }
        });
    });

    mobile.addEventListener('change', synchronizeLayout);
}
