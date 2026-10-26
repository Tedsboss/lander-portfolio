<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta name="theme-color" content="#0b0c10">

    <meta
        name="description"
        content="Explore Lander's software development experience, government systems, and community projects."
    >

    <title>
        @yield('title', config('portfolio.name', 'Lander').' — Software Developer')
    </title>

    <link
        rel="icon"
        href="{{ asset('favicon.svg') }}"
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
        $navigationResumeAvailable = is_file(
            public_path('downloads/lander-resume2.pdf')
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
            <a
                class="logo"
                href="{{ route('portfolio.index') }}"
                aria-label="Lander home"
            >
                <span class="logo-symbol" aria-hidden="true">
                    L<span>↗</span>
                </span>

                LANDER<span class="logo-ext">.DEV</span>
            </a>

            <button
                type="button"
                class="portfolio-menu-toggle"
                data-nav-toggle
                aria-label="Open navigation"
                aria-controls="portfolio-navigation"
                aria-expanded="false"
                hidden
            >
                <span data-nav-icon aria-hidden="true">☰</span>
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

                    <span class="portfolio-nav-count">
                        {{ count(config('portfolio.projects', [])) }}
                    </span>
                </a>

                <a href="{{ route('portfolio.index') }}#community">
                    Community
                </a>

                <a href="{{ route('portfolio.index') }}#about">
                    About
                </a>
            </nav>

            @if ($navigationResumeAvailable)
                <a
                    class="nav-download"
                    href="{{ asset('downloads/lander-resume2.pdf') }}"
                    download="lander-resume2.pdf"
                    aria-label="Download Lander's résumé as a PDF"
                >
                    Résumé
                    <span aria-hidden="true">↓</span>
                </a>
            @else
                <button
                    type="button"
                    class="nav-download"
                    title="The résumé PDF will be available soon."
                    disabled
                >
                    Résumé soon
                </button>
            @endif
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="footer shell">
        <a
            class="logo"
            href="{{ route('portfolio.index') }}"
        >
            LANDER<span class="logo-ext">.DEV</span>
        </a>

        <span>
            CODE WITH PURPOSE. BUILD FOR PEOPLE.
        </span>

        <span>
            © {{ now()->year }} LANDER

            <a href="{{ route('portfolio.index') }}#main">
                ↑ BACK TO TOP
            </a>
        </span>
    </footer>

    <div
        class="toast"
        role="status"
        aria-live="polite"
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

        <p>Copy the project link below.</p>

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
