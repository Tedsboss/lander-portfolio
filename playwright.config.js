import { defineConfig, devices } from '@playwright/test';

const baseURL = 'http://127.0.0.1:8010';

export default defineConfig({
    testDir: './tests/browser',

    fullyParallel: false,
    forbidOnly: Boolean(process.env.CI),
    retries: process.env.CI ? 1 : 0,
    workers: 1,
    timeout: 30_000,

    expect: {
        timeout: 10_000,
    },

    reporter: [
        ['list'],
        ['html', { open: 'never' }],
    ],

    use: {
        baseURL,
        reducedMotion: 'reduce',
        trace: 'retain-on-failure',
        screenshot: 'only-on-failure',
    },

    projects: [
        {
            name: 'chromium',
            use: {
                ...devices['Desktop Chrome'],
            },
        },
    ],

    webServer: {
        command:
            'php artisan serve --host=127.0.0.1 --port=8010 --no-reload',

        url: baseURL,
        reuseExistingServer: false,
        timeout: 60_000,

        env: {
            APP_ENV: 'testing',
            APP_DEBUG: 'true',
            APP_URL: baseURL,
            SESSION_DRIVER: 'array',
            CACHE_STORE: 'array',
            QUEUE_CONNECTION: 'sync',
        },
    },
});
