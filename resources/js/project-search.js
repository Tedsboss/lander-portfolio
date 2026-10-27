const projectSearch = document.getElementById('project-search');
const clearSearch = document.querySelector(
    '[data-clear-project-search]'
);

if (projectSearch && clearSearch) {
    function updateClearButton() {
        clearSearch.hidden = projectSearch.value.length === 0;
    }

    function clearQuery() {
        projectSearch.value = '';

        projectSearch.dispatchEvent(
            new Event('input', { bubbles: true })
        );

        projectSearch.focus({ preventScroll: true });

        updateClearButton();
    }

    projectSearch.addEventListener('input', updateClearButton);

    clearSearch.addEventListener('click', clearQuery);

    projectSearch.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape' || !projectSearch.value) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        clearQuery();
    });

    document.addEventListener('keydown', (event) => {
        if (
            event.key !== '/' ||
            event.ctrlKey ||
            event.metaKey ||
            event.altKey ||
            event.defaultPrevented ||
            document.querySelector('dialog[open]')
        ) {
            return;
        }

        const focused = document.activeElement;

        const isEditing =
            focused instanceof HTMLElement &&
            (
                focused.matches(
                    'input, textarea, select, [role="textbox"]'
                ) ||
                focused.isContentEditable
            );

        if (isEditing) return;

        event.preventDefault();

        projectSearch.focus();
        projectSearch.select();
    });

    // The existing saved-project action resets the search value.
    document.querySelectorAll('[data-open-saved]').forEach((button) => {
        button.addEventListener('click', () => {
            requestAnimationFrame(updateClearButton);
        });
    });

    window.addEventListener('pageshow', updateClearButton);

    updateClearButton();
}
