import { inject } from '@vercel/analytics';

if (import.meta.env.PROD) {
    inject({
        mode: 'production',
    });
}
