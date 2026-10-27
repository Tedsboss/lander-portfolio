import '../css/portfolio-motion.css';

function initPortfolioMotion() {
    const root = document.documentElement;
    const scene = document.querySelector('.hero-scene');
    const carousel = document.querySelector('.carousel');

    if ((!scene && !carousel) || root.dataset.p4d) return;

    const reduced = matchMedia('(prefers-reduced-motion: reduce)');
    const desktop = matchMedia(
        '(min-width: 768px) and (hover: hover) and (pointer: fine)'
    );

    const storageKey = 'lander.motion.paused';
    let paused = false;

    try {
        paused = localStorage.getItem(storageKey) === 'true';
    } catch {
        // Continue when browser storage is unavailable.
    }

    // Place the control beside the existing hero buttons.
    const controls = document.querySelector('.hero-buttons');
    const toggle = document.createElement('button');

    toggle.type = 'button';
    toggle.className = 'p4d-toggle';
    controls?.append(toggle);

    function running() {
        return (
            !paused &&
            !reduced.matches &&
            desktop.matches &&
            !document.hidden
        );
    }

    function reset(element) {
        element.style.setProperty('--p4d-x', '50%');
        element.style.setProperty('--p4d-y', '50%');
        element.style.setProperty('--p4d-rx', '0deg');
        element.style.setProperty('--p4d-ry', '0deg');
    }

    const targets = [
        scene,
        ...document.querySelectorAll('.carousel .card-visual'),
    ].filter(Boolean);

    function sync() {
        root.dataset.p4d = running() ? 'running' : 'paused';

        toggle.hidden = reduced.matches || !desktop.matches;
        toggle.textContent = paused ? 'Resume motion' : 'Pause motion';
        toggle.setAttribute('aria-pressed', String(paused));

        if (!running()) targets.forEach(reset);
    }

    toggle.addEventListener('click', () => {
        paused = !paused;

        try {
            localStorage.setItem(storageKey, String(paused));
        } catch {
            // The preference still applies to the current visit.
        }

        sync();
    });

    // Pointer lighting and tilt; at most one update per animation frame.
    targets.forEach((element) => {
        let x = 0.5;
        let y = 0.5;
        let frame = 0;

        element.addEventListener('pointermove', (event) => {
            if (!running() || event.pointerType === 'touch') return;

            const rect = element.getBoundingClientRect();

            if (!rect.width || !rect.height) return;

            x = Math.max(
                0,
                Math.min(1, (event.clientX - rect.left) / rect.width)
            );

            y = Math.max(
                0,
                Math.min(1, (event.clientY - rect.top) / rect.height)
            );

            if (frame) return;

            frame = requestAnimationFrame(() => {
                frame = 0;

                if (!running()) return;

                element.style.setProperty('--p4d-x', `${x * 100}%`);
                element.style.setProperty('--p4d-y', `${y * 100}%`);
                element.style.setProperty(
                    '--p4d-rx',
                    `${(0.5 - y) * 12}deg`
                );
                element.style.setProperty(
                    '--p4d-ry',
                    `${(x - 0.5) * 16}deg`
                );
            });
        }, { passive: true });

        function leave() {
            cancelAnimationFrame(frame);
            frame = 0;
            reset(element);
        }

        element.addEventListener('pointerleave', leave);
        element.addEventListener('pointercancel', leave);
        window.addEventListener('blur', leave);
    });

    // Decorative particles use the existing hero illustration.
    if (scene) {
        scene.classList.add('p4d-scene');

        const particles = document.createElement('div');
        particles.className = 'p4d-particles';
        particles.setAttribute('aria-hidden', 'true');

        for (let i = 0; i < 14; i++) {
            const dot = document.createElement('span');

            dot.style.setProperty('--x', `${8 + ((i * 37) % 84)}%`);
            dot.style.setProperty('--y', `${12 + ((i * 29) % 76)}%`);
            dot.style.setProperty('--delay', `${-i * 0.7}s`);

            particles.append(dot);
        }

        scene.prepend(particles);

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(([entry]) => {
                scene.classList.toggle(
                    'p4d-offscreen',
                    !entry.isIntersecting
                );
            });

            observer.observe(scene);
        }
    }

    // Enhance the native carousel without replacing its controls.
    if (carousel) {
        carousel.classList.add('p4d-carousel');

        const cards = [
            ...carousel.querySelectorAll('.showcase-card'),
        ];

        let frame = 0;

        function update() {
            frame = 0;

            if (!cards.length) return;

            const carouselLeft = carousel.getBoundingClientRect().left;

            let active = 0;
            let nearestDistance = Infinity;

            cards.forEach((card, index) => {
                const distance = Math.abs(
                    card.getBoundingClientRect().left - carouselLeft
                );

                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    active = index;
                }
            });

            cards.forEach((card, index) => {
                const isActive = index === active;

                card.classList.toggle('p4d-active', isActive);

                const visual = card.querySelector('.card-visual');

                if (!visual) return;

                const relativePosition = Math.max(
                    -2,
                    Math.min(2, index - active)
                );

                visual.style.setProperty(
                    '--p4d-lean',
                    `${relativePosition * 5}deg`
                );

                visual.style.setProperty(
                    '--p4d-lift',
                    isActive ? '-6px' : '0px'
                );
            });
        }

        function schedule() {
            if (frame) return;

            frame = requestAnimationFrame(update);
        }

        carousel.addEventListener('scroll', schedule, {
            passive: true,
        });

        window.addEventListener('resize', schedule, {
            passive: true,
        });

        if ('ResizeObserver' in window) {
            const resizeObserver = new ResizeObserver(schedule);

            resizeObserver.observe(carousel);

            cards.forEach((card) => {
                resizeObserver.observe(card);
            });
        }

        update();
    }

    reduced.addEventListener('change', sync);
    desktop.addEventListener('change', sync);
    document.addEventListener('visibilitychange', sync);

    sync();
}

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initPortfolioMotion,
        { once: true }
    );
} else {
    initPortfolioMotion();
}
