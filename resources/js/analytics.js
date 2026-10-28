import { inject } from '@vercel/analytics';

const isLivePortfolio =
    window.location.hostname === 'lander-portfolio-iota.vercel.app';

if (import.meta.env.PROD && isLivePortfolio) {
    inject({
        mode: 'production',
    });
}
