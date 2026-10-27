const navigation = document.querySelector('[data-nav-panel]');
const header = document.querySelector('[data-portfolio-header]');

if (navigation && header) {
    const sections = [];

    navigation.querySelectorAll('a[href]').forEach((link) => {
        const destination = new URL(link.href, window.location.href);

        if (
            destination.origin !== window.location.origin ||
            destination.pathname !== window.location.pathname ||
            !destination.hash
        ) {
            return;
        }

        let section;

        try {
            section = document.getElementById(
                decodeURIComponent(destination.hash.slice(1))
            );
        } catch {
            return;
        }

        if (section) {
            sections.push({ link, section });
        }
    });

    if (sections.length) {
        let frame = 0;

        function updateActiveSection() {
            frame = 0;

            const readingLine =
                header.getBoundingClientRect().bottom + 32;

            let activeSection = null;

            for (const item of sections) {
                const position = item.section.getBoundingClientRect();

                if (
                    item.section.getClientRects().length &&
                    position.top <= readingLine
                ) {
                    if (
                        !activeSection ||
                        position.top > activeSection.top
                    ) {
                        activeSection = {
                            link: item.link,
                            top: position.top,
                        };
                    }
                }
            }

            sections.forEach(({ link }) => {
                const active = link === activeSection?.link;

                link.classList.toggle('is-current-section', active);

                if (active) {
                    link.setAttribute('aria-current', 'location');
                } else {
                    link.removeAttribute('aria-current');
                }
            });
        }

        function scheduleUpdate() {
            if (frame) return;

            frame = requestAnimationFrame(updateActiveSection);
        }

        window.addEventListener('scroll', scheduleUpdate, {
            passive: true,
        });

        window.addEventListener('resize', scheduleUpdate, {
            passive: true,
        });

        window.addEventListener('hashchange', scheduleUpdate);
        window.addEventListener('load', scheduleUpdate);
        window.addEventListener('pageshow', scheduleUpdate);

        if ('ResizeObserver' in window) {
            const observer = new ResizeObserver(scheduleUpdate);

            observer.observe(header);

            sections.forEach(({ section }) => {
                observer.observe(section);
            });
        }

        updateActiveSection();
    }
}
