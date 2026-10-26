@extends('layouts.app')

@section('content')
    @php
        $featuredProjects = $allProjects->take(5);
        $communityProjects = $allProjects->where('category', 'community');
        $projectCount = $allProjects->count();
        $profileName = config('portfolio.name', 'Lander');
    @endphp

    {{-- Hero --}}
    <section class="hero shell" aria-labelledby="hero-title">
        <div class="hero-copy">
            <div class="eyebrow">
                <span class="live-dot" aria-hidden="true"></span>
                PLAYER 01 / SENIOR SOFTWARE DEVELOPER
            </div>

            <h1 id="hero-title">
                REAL SYSTEMS.<br>
                <span class="outline-text">NEXT</span>
                <span class="lime-text">LEVEL.</span>
            </h1>

            <p class="hero-intro">
                Hey, I’m {{ $profileName }}. I build digital experiences
                that move public service forward. Complex workflows.
                Thoughtful code. Real-world purpose.
            </p>

            <div class="hero-buttons">
                <a class="btn btn-lime" href="#showcase">
                    Explore my universe
                    <span aria-hidden="true">↗</span>
                </a>

                <a class="text-link" href="#download">
                    Download portfolio
                    <span aria-hidden="true">↓</span>
                </a>
            </div>

            <div class="hero-signature">
                <span class="mini-cross" aria-hidden="true">✳</span>

                <span>
                    BUILT IN THE PHILIPPINES.<br>
                    MADE TO MAKE A DIFFERENCE.
                </span>

                <span class="signature-line" aria-hidden="true"></span>
            </div>
        </div>

        <div
            class="hero-scene"
            data-tilt
            role="img"
            aria-label="Three-dimensional software core illustration"
        >
            <div class="scene-grid"></div>

            <span class="scene-corner top-left"></span>
            <span class="scene-corner bottom-right"></span>

            <div class="scene-coordinate">
                SYS.CORE / 01<br>
                <span>PHP · LARAVEL · TAILWIND</span>
            </div>

            <div class="core-glow"></div>

            <div class="orbit orbit-a"></div>
            <div class="orbit orbit-b"></div>
            <div class="orbit orbit-c"></div>

            <div class="cube-wrap">
                <div class="cube">
                    <div class="cube-face face-front">
                        <span>&lt;/&gt;</span>
                        <small>LANDER.DEV</small>
                    </div>

                    <div class="cube-face face-back"></div>

                    <div class="cube-face face-right">
                        <span>01</span>
                    </div>

                    <div class="cube-face face-left"></div>

                    <div class="cube-face face-top">
                        <span>✳</span>
                    </div>

                    <div class="cube-face face-bottom"></div>
                </div>
            </div>

            <div class="floating-chip chip-a">
                <span class="chip-icon">↗</span>

                <div>
                    PUBLIC SECTOR
                    <small>SOFTWARE WITH PURPOSE</small>
                </div>
            </div>

            <div class="floating-chip chip-b">
                <span class="chip-icon">⌘</span>

                <div>
                    FULL STACK
                    <small>FROM DATA TO EXPERIENCE</small>
                </div>
            </div>

            <span class="scene-caption">
                MOVE YOUR CURSOR. SHIFT YOUR PERSPECTIVE.
                <span>+</span>
            </span>

            <span class="scene-star star-one">+</span>
            <span class="scene-star star-two">+</span>
        </div>
    </section>

    {{-- Toolkit --}}
    <div class="tech-strip">
        <div class="shell tech-strip-inner">
            <span class="strip-label">
                MY TOOLKIT <span aria-hidden="true">→</span>
            </span>

            <span>PHP</span>
            <i aria-hidden="true">✦</i>
            <span>LARAVEL</span>
            <i aria-hidden="true">✦</i>
            <span>TAILWIND CSS</span>
            <i aria-hidden="true">✦</i>
            <span>MYSQL</span>
            <i aria-hidden="true">✦</i>
            <span>REACT</span>
            <i aria-hidden="true">✦</i>
            <span>API INTEGRATION</span>
        </div>
    </div>

    {{-- Featured project carousel --}}
    <section
        class="showcase shell section"
        id="showcase"
        aria-labelledby="showcase-title"
    >
        <div class="section-heading">
            <div>
                <span class="eyebrow">
                    <span class="section-no">01</span>
                    FEATURED MISSIONS
                </span>

                <h2 id="showcase-title">
                    CHOOSE YOUR
                    <span class="serif-neon">PROJECT.</span>
                </h2>
            </div>

            <div class="carousel-controls">
                <span class="carousel-position" aria-live="polite">
                    01 / {{ str_pad((string) $featuredProjects->count(), 2, '0', STR_PAD_LEFT) }}
                </span>

                <button
                    type="button"
                    data-carousel-prev
                    aria-label="Previous featured project"
                >
                    ←
                </button>

                <button
                    type="button"
                    data-carousel-next
                    aria-label="Next featured project"
                >
                    →
                </button>
            </div>
        </div>

        <div
            class="carousel"
            role="region"
            aria-label="Game-inspired project showcase"
            aria-roledescription="carousel"
            tabindex="0"
        >
            @foreach ($featuredProjects as $project)
                @php
                    $theme = $project['theme']
                        ?? ($project['id'] === 'ppms' ? 'blue' : 'lime');

                    $projectNumber = str_pad(
                        (string) $project['number'],
                        2,
                        '0',
                        STR_PAD_LEFT
                    );
                @endphp

                <article
                    class="showcase-card theme-{{ $theme }}"
                    aria-label="{{ $project['code'] }} featured project"
                >
                    <div class="card-visual" aria-hidden="true">
                        <div class="cover-grid"></div>

                        <span class="cover-meta">
                            FEATURED SYSTEM / {{ $projectNumber }}
                        </span>

                        <span class="cover-cross">+</span>

                        <div class="cover-device device-{{ $project['id'] }}">
                            <div class="device-top">
                                <i></i>
                                <i></i>
                                <i></i>
                                <span>{{ $project['code'] }}.SYS</span>
                            </div>

                            <div class="device-content">
                                <div class="device-sidebar">
                                    <b></b>
                                    <b></b>
                                    <b></b>
                                    <b></b>
                                </div>

                                <div class="device-main">
                                    <span>{{ $project['label'] }}</span>

                                    <div class="device-bars">
                                        <i></i>
                                        <i></i>
                                        <i></i>
                                        <i></i>
                                        <i></i>
                                    </div>

                                    <div class="device-data">
                                        <b></b>
                                        <b></b>
                                        <b></b>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <strong class="cover-code">
                            {{ $project['code'] }}
                        </strong>

                        <span class="cover-foot">
                            CONCEPTUAL SYSTEM ARTWORK
                            <span>↗</span>
                        </span>
                    </div>

                    <div class="showcase-card-body">
                        <div class="card-category">
                            <span>{{ $project['label'] }}</span>
                            <span>{{ $projectNumber }}</span>
                        </div>

                        <h3>
                            <a href="{{ route('portfolio.show', $project['id']) }}">
                                {{ $project['code'] }}
                                <span aria-hidden="true">↗</span>
                            </a>
                        </h3>

                        <p>{{ $project['name'] }}</p>

                        <div class="card-bottom">
                            <span class="role-chip">
                                {{ $project['role'] ?? 'Project experience' }}
                            </span>

                            <button
                                type="button"
                                class="save-button"
                                data-save="{{ $project['id'] }}"
                                aria-label="Save {{ $project['code'] }}"
                                aria-pressed="false"
                            >
                                +
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="showcase-bottom">
            <span>REAL PROJECTS. GAME-INSPIRED PRESENTATION.</span>

            <a href="#projects">
                VIEW ALL {{ $projectCount }} PROJECTS
                <span aria-hidden="true">↗</span>
            </a>
        </div>
    </section>

    {{-- Searchable project archive --}}
    <section
        class="archive shell section"
        id="projects"
        data-initial-filter="{{ $category }}"
        aria-labelledby="archive-title"
    >
        <div class="section-heading">
            <div>
                <span class="eyebrow">
                    <span class="section-no">02</span>
                    THE COMPLETE COLLECTION
                </span>

                <h2 id="archive-title">
                    THE PROJECT
                    <span class="serif-neon">ARCHIVE.</span>
                </h2>
            </div>

            <p>
                Different systems. One purpose.<br>
                Make the work work better.
            </p>
        </div>

        <div class="archive-toolbar">
            <div
                class="filter-tabs"
                role="group"
                aria-label="Filter project archive"
            >
                @foreach (['all' => 'All projects'] + config('portfolio.categories') as $key => $label)
                    <a
                        href="{{ route('portfolio.index', $key === 'all' ? [] : ['category' => $key]) }}#projects"
                        @class([
                            'filter',
                            'active' => $category === $key,
                        ])
                        data-filter="{{ $key }}"
                        @if ($category === $key)
                            aria-current="page"
                        @endif
                    >
                        {{ $label }}
                        <span>{{ $counts[$key] }}</span>
                    </a>
                @endforeach

                <button
                    type="button"
                    class="filter"
                    data-filter="saved"
                    aria-pressed="false"
                >
                    Saved
                    <span data-saved-count>0</span>
                </button>
            </div>

            <label class="search">
                <span aria-hidden="true">⌕</span>

                <input
                    type="search"
                    placeholder="Find a project…"
                    aria-label="Find a project"
                >
            </label>
        </div>

        <div class="archive-header" aria-hidden="true">
            <span>PROJECT / SYSTEM</span>
            <span>DOMAIN</span>
            <span>EXPLORE</span>
        </div>

        <div class="archive-list">
            @foreach ($allProjects as $project)
                <article
                    class="archive-row"
                    data-project="{{ $project['id'] }}"
                    data-category="{{ $project['category'] }}"
                    data-search="{{ $project['code'].' '.$project['name'].' '.$project['label'] }}"
                    @if ($category !== 'all' && $project['category'] !== $category)
                        hidden
                    @endif
                >
                    <span class="row-index">
                        {{ str_pad((string) $project['number'], 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <a
                        class="row-title"
                        href="{{ route('portfolio.show', $project['id']) }}"
                    >
                        <strong>{{ $project['code'] }}</strong>
                        <span>{{ $project['name'] }}</span>
                    </a>

                    <span class="row-domain">
                        {{ $project['label'] }}
                    </span>

                    <div class="row-actions">
                        <button
                            type="button"
                            class="save-button"
                            data-save="{{ $project['id'] }}"
                            aria-label="Save {{ $project['code'] }}"
                            aria-pressed="false"
                        >
                            +
                        </button>

                        <a
                            class="row-arrow"
                            href="{{ route('portfolio.show', $project['id']) }}"
                            aria-label="View {{ $project['code'] }} project"
                        >
                            ↗
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="archive-empty" hidden>
            No projects here yet. Try another filter or save a project
            with the + button.
        </div>

        <div class="archive-foot">
            <span data-result-count aria-live="polite">
                {{ $projects->count() }}
                {{ $projects->count() === 1 ? 'PROJECT' : 'PROJECTS' }}
            </span>

            <span>
                <span class="lime-dot" aria-hidden="true"></span>
                SAVED PROJECTS STAY ON THIS DEVICE
            </span>
        </div>
    </section>

    {{-- Community project spotlights --}}
    <section
        class="community-section"
        id="community"
        aria-labelledby="community-title"
    >
        <div class="shell section">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">
                        <span class="section-no">03</span>
                        THE HUMAN SIDE OF THE CODE
                    </span>

                    <h2 id="community-title">
                        SMALL COMMUNITIES.<br>
                        <span class="serif-neon">
                            BIG POSSIBILITIES.
                        </span>
                    </h2>
                </div>

                <p>
                    Closer to the people.<br>
                    Barangay systems built around local needs.
                </p>
            </div>

            <div class="community-grid">
                @foreach ($communityProjects as $project)
                    <article class="community-card {{ $project['id'] }}">
                        <div class="community-card-top">
                            <span class="community-icon" aria-hidden="true">
                                {{ $project['id'] === 'sagad' ? '⌘' : '✳' }}
                            </span>

                            <span class="status-pill">
                                {{ $project['status'] ?? 'Thesis project' }}
                            </span>
                        </div>

                        <span class="eyebrow">
                            COMMUNITY PROJECT
                        </span>

                        <h3>
                            {{ $project['code'] }}
                            <span>{{ $project['name'] }}</span>
                        </h3>

                        <p>{{ $project['description'] }}</p>

                        <div class="community-actions">
                            <a
                                class="text-link"
                                href="{{ route('portfolio.show', $project['id']) }}"
                            >
                                Explore project
                                <span aria-hidden="true">↗</span>
                            </a>

                            <button
                                type="button"
                                class="share-button"
                                data-share="{{ route('portfolio.show', $project['id']) }}"
                                data-share-name="{{ $project['code'] }}"
                                aria-label="Share {{ $project['code'] }} project"
                            >
                                ↗ Share
                            </button>
                        </div>
                    </article>
                @endforeach

                <div class="collection-panel">
                    <span class="community-icon" aria-hidden="true">⌘</span>

                    <span class="eyebrow">
                        YOUR PROJECT COLLECTION
                    </span>

                    <h3>
                        Keep the ones<br>
                        that click.
                    </h3>

                    <p>
                        Save projects as you explore. Build a personal
                        collection, then share a project with someone
                        who might find it useful.
                    </p>

                    <button
                        type="button"
                        class="text-link"
                        data-open-saved
                    >
                        Open saved projects
                        <span data-saved-count>0</span>
                        <span aria-hidden="true">↗</span>
                    </button>

                    <small>
                        Stored in this browser. No account needed.
                    </small>
                </div>
            </div>
        </div>
    </section>

    {{-- Developer profile --}}
    <section
        class="about shell section"
        id="about"
        aria-labelledby="about-title"
    >
        <div class="about-identity">
            <div class="avatar-cube" aria-hidden="true">
                L<span>↗</span>
            </div>

            <span class="eyebrow">MEET THE BUILDER</span>

            <h2 id="about-title">
                HUMAN FIRST.<br>
                <span class="serif-neon">
                    DEVELOPER ALWAYS.
                </span>
            </h2>

            <p class="about-name">
                {{ $profileName }}

                <span>
                    {{ config('portfolio.role', 'Senior Software Developer') }}
                    /
                    {{ config('portfolio.location', 'Philippines') }}
                </span>
            </p>
        </div>

        <div class="about-copy">
            <span class="terminal-caption">
                <i aria-hidden="true"></i>
                ABOUT.ME
            </span>

            <h3>
                I turn complex processes into software people can use.
            </h3>

            <p>
                My work spans government information systems, project
                monitoring, financial planning, innovation grants,
                and infrastructure data. I contribute through development,
                interface improvements, workflow fixes, API integration,
                and ongoing maintenance.
            </p>

            <p>
                From national platforms to barangay projects, I care
                about the same thing: understanding the people behind
                the process and building something that helps.
            </p>

            <div class="skill-tags">
                @foreach (config('portfolio.skills', []) as $skill)
                    <span>{{ $skill }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Résumé download --}}
    <section
        class="download-section shell"
        id="download"
        aria-labelledby="download-title"
    >
        @php
            $resumeAvailable = is_file(
                public_path('downloads/lander-resume2.pdf')
            );
        @endphp

        <div class="download-panel">
            <div class="download-art" aria-hidden="true">
                <div class="download-sheet">
                    <span>LANDER.DEV</span>

                    <strong>
                        MY<br>
                        RÉSUMÉ
                        <span>↗</span>
                    </strong>

                    <div class="paper-lines"></div>

                    <small>SENIOR SOFTWARE DEVELOPER</small>
                </div>

                <div class="download-orbit"></div>
            </div>

            <div class="download-copy">
                <span class="eyebrow">
                    EXPERIENCE / SKILLS / PROJECTS
                </span>

                <h2 id="download-title">
                    THE DEVELOPER.<br>

                    <span class="lime-text">
                        BEHIND THE CODE.
                    </span>
                </h2>

                <p>
                    Explore my professional experience, technical skills,
                    and contributions to government and community systems.
                </p>

                @if ($resumeAvailable)
                    <a
                        class="btn btn-lime"
                        href="{{ asset('downloads/lander-resume2.pdf') }}"
                        download="lander-resume2.pdf"
                        aria-label="Download Lander's résumé as a PDF"
                    >
                        Download résumé
                        <span aria-hidden="true">↓</span>
                    </a>

                    <small>
                        PDF FORMAT
                        <span aria-hidden="true">✦</span>
                        RÉSUMÉ
                    </small>
                @else
                    <button
                        type="button"
                        class="btn btn-lime"
                        disabled
                    >
                        Résumé available soon
                    </button>

                    <small>
                        THE RÉSUMÉ PDF WILL BE ADDED SOON
                    </small>
                @endif
            </div>
        </div>
    </section>
@endsection
