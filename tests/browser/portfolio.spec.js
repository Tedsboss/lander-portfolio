import { test, expect } from '@playwright/test';

test.beforeEach(async ({ page }) => {
    await page.goto('/');

    // Wait until the JavaScript modules have initialized.
    await expect(
        page.locator('[data-portfolio-header]')
    ).toHaveAttribute('data-nav-ready', 'true');
});

test('search and clear preserve the selected category', async ({ page }) => {
    const archive = page.locator('#projects');
    const search = page.getByRole('searchbox', {
        name: 'Find a project',
    });

    await page.locator('[data-filter="government"]').click();
    await search.fill('NPMCS');

    await expect(
        archive.locator('[data-project][data-category]:visible')
    ).toHaveCount(1);

    await expect(
        archive.locator('[data-project="npmcs"]')
    ).toBeVisible();

    await page.locator('[data-clear-project-search]').click();

    await expect(search).toHaveValue('');

    await expect(
        page.locator('[data-filter="government"]')
    ).toHaveClass(/\bactive\b/);
});

test('empty search can reset to all projects', async ({ page }) => {
    const search = page.getByRole('searchbox', {
        name: 'Find a project',
    });

    await search.fill('zzzz-no-matching-project');

    await expect(page.locator('.archive-empty')).toBeVisible();

    await page.locator('[data-reset-project-search]').click();

    await expect(search).toHaveValue('');
    await expect(page.locator('.archive-empty')).toBeHidden();

    await expect(
        page.locator('[data-filter="all"]')
    ).toHaveClass(/\bactive\b/);

    await expect(
        page.locator('#projects [data-project="direk"]')
    ).toBeVisible();
});

test('search and category survive a project visit', async ({ page }) => {
    await page.locator('[data-filter="government"]').click();

    await page.getByRole('searchbox', {
        name: 'Find a project',
    }).fill('NPMCS');

    await page.locator(
        '#projects [data-project="npmcs"] .archive-preview-link'
    ).click();

    await expect(page).toHaveURL(/\/projects\/npmcs$/);

    await page.locator('.back-link').click();

    await expect(
        page.getByRole('searchbox', { name: 'Find a project' })
    ).toHaveValue('NPMCS');

    await expect(
        page.locator('[data-filter="government"]')
    ).toHaveClass(/\bactive\b/);
});

test('shared URL restores the requested search', async ({ page }) => {
    await page.goto('/?category=government&q=NPMCS#projects');

    await expect(
        page.getByRole('searchbox', { name: 'Find a project' })
    ).toHaveValue('NPMCS');

    await expect(
        page.locator('[data-filter="government"]')
    ).toHaveClass(/\bactive\b/);

    await expect(
        page.locator('#projects [data-project][data-category]:visible')
    ).toHaveCount(1);
});

test('saved projects survive a reload', async ({ page }) => {
    const saveButton = page.locator(
        '#projects [data-project="direk"] [data-save]'
    );

    await saveButton.click();

    await expect(saveButton).toHaveAttribute(
        'aria-pressed',
        'true'
    );

    await page.reload();

    await expect(
        page.locator(
            '#projects [data-project="direk"] [data-save]'
        )
    ).toHaveAttribute('aria-pressed', 'true');

    await page.locator('[data-filter="saved"]').click();

    await expect(
        page.locator('#projects [data-project][data-category]:visible')
    ).toHaveCount(1);
});

test('background selection survives a reload', async ({ page }) => {
    const picker = page.locator('[data-background-picker]');

    await expect(picker).toBeVisible();

    await picker.locator('summary').click();
    await picker.locator('input[value="dota"]').check();

    await expect(page.locator('html')).toHaveAttribute(
        'data-background-theme',
        'dota'
    );

    await page.reload();

    await expect(page.locator('html')).toHaveAttribute(
        'data-background-theme',
        'dota'
    );

    await picker.locator('summary').click();
    await picker.locator('input[value="plain"]').check();

    await expect(page.locator('html')).toHaveAttribute(
        'data-background-theme',
        'plain'
    );
});

test('mobile menu supports Escape and section navigation', async ({ page }) => {
    await page.setViewportSize({
        width: 390,
        height: 844,
    });

    const toggle = page.locator('[data-nav-toggle]');
    const navigation = page.locator('[data-nav-panel]');

    await expect(toggle).toBeVisible();
    await expect(navigation).toBeHidden();

    await toggle.click();

    await expect(navigation).toBeVisible();
    await expect(toggle).toHaveAttribute('aria-expanded', 'true');

    await page.keyboard.press('Escape');

    await expect(navigation).toBeHidden();
    await expect(toggle).toBeFocused();

    await toggle.click();
    await navigation.getByRole('link', {
        name: 'Contact',
        exact: true,
    }).click();

    await expect(toggle).toHaveAttribute('aria-expanded', 'false');
    await expect(navigation).toBeHidden();
    await expect(page).toHaveURL(/#contact$/);
});

test('gallery selection and enlargement work', async ({ page }) => {
    await page.goto('/projects/direk');

    const gallery = page.locator('[data-project-gallery]');

    await expect(gallery).toHaveAttribute(
        'data-initialized',
        /.+/
    );

    const secondThumbnail = gallery
        .locator('[data-gallery-shot]')
        .nth(1);

    const screenshotUrl = await secondThumbnail.evaluate(
        (link) => link.href
    );

    await secondThumbnail.click();

    await expect(
        gallery.locator('[data-gallery-image]')
    ).toHaveAttribute('src', screenshotUrl);

    await gallery.locator('[data-gallery-open]').click();

    const lightbox = gallery.locator('[data-project-lightbox]');

    await expect(lightbox).toBeVisible();

    await page.keyboard.press('Escape');

    await expect(lightbox).toBeHidden();

    await expect(
        gallery.locator('[data-gallery-open]')
    ).toBeFocused();
});
