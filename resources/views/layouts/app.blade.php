<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0b0c10">

    <meta
        name="description"
        content="Lander — Senior Software Developer. Government platforms, community systems, and software built with purpose."
    >

    <title>
        @yield(
            'title',
            config('portfolio.name', 'Lander').' — '.
            config('portfolio.role', 'Senior Software Developer')
        )
    </title>

    <link
        rel="icon"
        href="{{ asset('favicon.svg') }}?v=2"
        type="image/svg+xml"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="antialiased">
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
                aria-label="Toggle navigation"
            >
                <span aria-hidden="true">☰</span>
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

    <main id="main">
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

    @stack('scripts')
</body>
</html>
