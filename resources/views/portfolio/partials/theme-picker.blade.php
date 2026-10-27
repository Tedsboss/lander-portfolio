<div class="background-picker" data-background-picker hidden>
    <details class="background-picker__details">
        <summary class="background-picker__toggle">
            <span aria-hidden="true">◈</span>
            <span>Theme</span>
        </summary>

        <div class="background-picker__panel">
            <fieldset class="background-picker__fieldset">
                <legend>Choose your atmosphere</legend>

                <label class="background-choice">
                    <input
                        type="radio"
                        name="portfolio-background"
                        value="celestial"
                    >

                    <span
                        class="background-choice__swatch background-choice__swatch--celestial"
                        aria-hidden="true"
                    ></span>

                    <span>
                        <strong>Celestial</strong>
                        <small>Amethyst clouds and gold starlight</small>
                    </span>
                </label>

                <label class="background-choice">
                    <input
                        type="radio"
                        name="portfolio-background"
                        value="dota"
                    >

                    <span
                        class="background-choice__swatch background-choice__swatch--dota"
                        aria-hidden="true"
                    ></span>

                    <span>
                        <strong>Dota-inspired</strong>
                        <small>A dark fantasy battlefield</small>
                    </span>
                </label>

                <label class="background-choice">
                    <input
                        type="radio"
                        name="portfolio-background"
                        value="plain"
                    >

                    <span
                        class="background-choice__swatch background-choice__swatch--plain"
                        aria-hidden="true"
                    ></span>

                    <span>
                        <strong>Plain Dark</strong>
                        <small>A clean, minimal background</small>
                    </span>
                </label>
            </fieldset>

            <p
                class="background-picker__status"
                data-background-status
                role="status"
                aria-live="polite"
            ></p>
        </div>
    </details>
</div>
