<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0b0c10">

    @php
        $siteName = config('portfolio.name', 'Lander');

        $pageTitle = trim($__env->yieldContent(
            'title',
            $siteName . ' — Senior Software Developer'
        ));

        $pageDescription = trim($__env->yieldContent(
            'description',
            'Explore Lander’s software development projects, including government information systems, project monitoring platforms, and community applications.'
        ));

        $pageUrl = url()->current();

        $socialImage = trim($__env->yieldContent(
            'social_image',
            asset('images/lander-social-preview.png')
        ));

        $socialImageAlt = trim($__env->yieldContent(
            'social_image_alt',
            'Marlon Lander Ortega — Senior Software Developer, with gold celestial branding and purple amethyst accents'
        ));
    @endphp

    <title>{{ $pageTitle }}</title>

    <meta name="description" content="{{ $pageDescription }}">
    <meta name="author" content="Marlon Lander Ortega">

    <link rel="canonical" href="{{ $pageUrl }}">

    {{-- Browser icon --}}
    <link
        rel="icon"
        type="image/svg+xml"
        href="{{ asset('favicon.svg') }}?v=2"
    >

    {{-- Social sharing --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="en_PH">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $pageUrl }}">
    <meta property="og:image" content="{{ $socialImage }}">
    <meta property="og:image:alt" content="{{ $socialImageAlt }}">

    {{-- X / Twitter sharing --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $socialImage }}">
    <meta name="twitter:image:alt" content="{{ $socialImageAlt }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <script>
        (() => {
            let theme = 'celestial';

            try {
                const saved = localStorage.getItem(
                    'lander.portfolio.background.v1'
                );

                if (['celestial', 'dota', 'plain'].includes(saved)) {
                    theme = saved;
                }
            } catch {
                // Use the default when browser storage is unavailable.
            }

            document.documentElement.dataset.backgroundTheme = theme;
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="antialiased">
        {{-- Decorative background --}}
        <div
            class="portfolio-atmosphere"
            aria-hidden="true"
            style="
                --celestial-background: url('{{ asset('images/portfolio-background.webp') }}');
                --dota-background: url('{{ asset('images/portfolio-dota-background.webp') }}');
            "
        ></div>
    @php
        $resumeAvailable = is_file(
            public_path('downloads/lander-resume.pdf')
        );
    @endphp

    <a class="skip" href="#main">
        Skip to content
    </a>

    <header
        class="portfolio-header"
        data-portfolio-header
        data-nav-open="false"
    >
        <div class="shell portfolio-nav-inner">
            <x-brand />

            <button
                type="button"
                class="portfolio-menu-toggle"
                data-nav-toggle
                aria-controls="portfolio-navigation"
                aria-expanded="false"
                aria-label="Open navigation"
                hidden
            >
                <span data-nav-icon aria-hidden="true">☰</span>
                <span>Menu</span>
            </button>

            <nav
                id="portfolio-navigation"
                class="portfolio-links"
                data-nav-panel
                aria-label="Main navigation"
            >
                <a href="{{ route('portfolio.index') }}#showcase">
                    Showcase
                </a>

                <a href="{{ route('portfolio.index') }}#projects">
                    Projects
                </a>

                <a href="{{ route('portfolio.index') }}#community">
                    Community
                </a>

                <a href="{{ route('portfolio.index') }}#about">
                    About
                </a>
                <a href="{{ route('portfolio.index') }}#contact">
                    Contact
                </a>

                @if ($resumeAvailable)
                    <a
                        class="nav-download"
                        href="{{ asset('downloads/lander-resume.pdf') }}"
                        download="Lander-Resume.pdf"
                    >
                        Résumé
                        <span aria-hidden="true">↓</span>
                    </a>
                @else
                    <span
                        class="nav-download"
                        aria-disabled="true"
                    >
                        Résumé soon
                    </span>
                @endif
            </nav>
        </div>
    </header>

    <main id="main" tabindex="-1">
        @yield('content')
    </main>

    <footer class="footer shell">
        <x-brand variant="footer" />

        <span>
            CODE WITH PURPOSE. BUILD FOR PEOPLE.
        </span>

        <span>
            © {{ now()->year }}
            {{ config('portfolio.name', 'Lander') }}

            <a href="{{ route('portfolio.index') }}#main">
                ↑ BACK TO TOP
            </a>
        </span>
    </footer>

    <div
        class="toast"
        role="status"
        aria-live="polite"
        aria-atomic="true"
        hidden
    ></div>

    <dialog
        class="share-dialog"
        aria-labelledby="share-title"
    >
        <div class="share-head">
            <h2 id="share-title">
                Share this project
            </h2>

            <button
                type="button"
                data-close-share
                aria-label="Close sharing dialog"
            >
                ×
            </button>
        </div>

        <p>
            Copy the project link below.
        </p>

        <input
            type="text"
            aria-label="Project link"
            readonly
        >

        <button
            type="button"
            class="btn btn-lime"
            data-copy-share
        >
            Copy link
            <span aria-hidden="true">↗</span>
        </button>
    </dialog>

    <a
        href="#main"
        class="portfolio-back-top"
        data-back-top
        aria-label="Back to top"
        hidden
    >
        <span aria-hidden="true">↑</span>
    </a>
    @include('portfolio.partials.theme-picker')
    @stack('scripts')
</body>
</html>
