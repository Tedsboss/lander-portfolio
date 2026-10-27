const backToTop = document.querySelector('[data-back-top]');
const main = document.getElementById('main');

if (backToTop && main) {
    const reducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    );

    let frame = 0;

    function updateVisibility() {
        frame = 0;

        const visible = window.scrollY > 500;

        if (!visible && document.activeElement === backToTop) {
            main.focus({ preventScroll: true });
        }

        backToTop.hidden = !visible;
    }

    function scheduleUpdate() {
        if (frame) return;

        frame = requestAnimationFrame(updateVisibility);
    }

    backToTop.addEventListener('click', (event) => {
        if (
            event.ctrlKey ||
            event.metaKey ||
            event.shiftKey ||
            event.altKey
        ) {
            return;
        }

        event.preventDefault();

        main.focus({ preventScroll: true });

        window.scrollTo({
            top: 0,
            behavior: reducedMotion.matches ? 'instant' : 'smooth',
        });
    });

    window.addEventListener('scroll', scheduleUpdate, {
        passive: true,
    });

    window.addEventListener('pageshow', scheduleUpdate);

    updateVisibility();
}
