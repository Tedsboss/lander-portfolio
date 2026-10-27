const picker = document.querySelector('[data-background-picker]');

if (picker) {
    const storageKey = 'lander.portfolio.background.v1';
    const allowedThemes = ['celestial', 'dota', 'plain'];

    const details = picker.querySelector('details');
    const summary = picker.querySelector('summary');
    const status = picker.querySelector('[data-background-status]');

    const controls = [
        ...picker.querySelectorAll(
            'input[name="portfolio-background"]'
        ),
    ];

    const names = {
        celestial: 'Celestial',
        dota: 'Dota-inspired',
        plain: 'Plain Dark',
    };

    function applyTheme(value, persist = false) {
        const theme = allowedThemes.includes(value)
            ? value
            : 'celestial';

        document.documentElement.dataset.backgroundTheme = theme;

        controls.forEach((control) => {
            control.checked = control.value === theme;
        });

        if (!persist) return;

        let saved = true;

        try {
            localStorage.setItem(storageKey, theme);
        } catch {
            saved = false;
        }

        if (status) {
            status.textContent = saved
                ? `${names[theme]} selected. Preference saved.`
                : `${names[theme]} selected for this visit.`;
        }
    }

    applyTheme(
        document.documentElement.dataset.backgroundTheme
    );

    picker.hidden = false;

    controls.forEach((control) => {
        control.addEventListener('change', () => {
            if (control.checked) {
                applyTheme(control.value, true);
            }
        });
    });

    document.addEventListener('click', (event) => {
        if (details.open && !picker.contains(event.target)) {
            const focusInside = picker.contains(
                document.activeElement
            );

            details.open = false;

            if (focusInside) {
                summary.focus({ preventScroll: true });
            }
        }
    });

    document.addEventListener('keydown', (event) => {
        if (
            event.key === 'Escape' &&
            !event.defaultPrevented &&
            details.open
        ) {
            event.preventDefault();

            details.open = false;
            summary.focus({ preventScroll: true });
        }
    });

    picker.addEventListener('focusout', () => {
        requestAnimationFrame(() => {
            if (!picker.contains(document.activeElement)) {
                details.open = false;
            }
        });
    });

    window.addEventListener('storage', (event) => {
        if (event.key === storageKey) {
            applyTheme(event.newValue);
        } else if (event.key === null) {
            applyTheme('celestial');
        }
    });
}
