@extends('layouts.app')

@section('content')
    @php
        $resumeAvailable = is_file(
            public_path('downloads/lander-resume.pdf')
        );

        $showcaseProjects = $allProjects->take(5);
        $projectCount = $allProjects->count();
        $communityProjects = $allProjects->where(
            'category',
            'community'
        );

        $filters = ['all' => 'All projects']
            + config('portfolio.categories', []);
    @endphp

    {{-- Hero --}}
    <section
        class="hero shell"
        aria-labelledby="hero-title"
    >
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
                Hey, I’m {{ config('portfolio.name', 'Lander') }}.
                I build digital experiences that move public service
                forward. Complex workflows. Thoughtful code.
                Real-world purpose.
            </p>

            <div class="hero-buttons">
                <a class="btn btn-lime" href="#showcase">
                    Explore my universe
                    <span aria-hidden="true">↗</span>
                </a>

                <a class="text-link" href="#download">
                    View my résumé
                    <span aria-hidden="true">↓</span>
                </a>
            </div>

            <div class="hero-signature">
                <span class="mini-cross" aria-hidden="true">✳</span>

                <span>
                    BUILT IN THE PHILIPPINES.<br>
                    MADE TO MAKE A DIFFERENCE.
                </span>

                <span
                    class="signature-line"
                    aria-hidden="true"
                ></span>
            </div>
        </div>

        <x-brand variant="hero" />
    </section>

    {{-- Technical toolkit --}}
    <div class="tech-strip">
        <div class="shell tech-strip-inner">
            <span class="strip-label">
                MY TOOLKIT
                <span aria-hidden="true">→</span>
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

    {{-- Featured projects --}}
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
                <span
                    class="carousel-position"
                    aria-live="polite"
                    aria-atomic="true"
                >
                    {{ $showcaseProjects->isEmpty() ? '00' : '01' }}
                    /
                    {{ str_pad($showcaseProjects->count(), 2, '0', STR_PAD_LEFT) }}
                </span>

                <button
                    type="button"
                    data-carousel-prev
                    aria-label="Previous featured project"
                    aria-controls="featured-carousel"
                >
                    ←
                </button>

                <button
                    type="button"
                    data-carousel-next
                    aria-label="Next featured project"
                    aria-controls="featured-carousel"
                >
                    →
                </button>
            </div>
        </div>

        <div
            class="carousel"
            id="featured-carousel"
            role="region"
            aria-label="Featured project showcase"
            aria-roledescription="carousel"
            tabindex="0"
        >
            @foreach ($showcaseProjects as $project)
                @include('portfolio.partials.showcase-card')
            @endforeach
        </div>

        <div class="showcase-bottom">
            <span>
                REAL PROJECTS. GAME-INSPIRED PRESENTATION.
            </span>

            <a href="#projects">
                VIEW ALL {{ $projectCount }} PROJECTS
                <span aria-hidden="true">↗</span>
            </a>
        </div>
    </section>

    {{-- Complete project archive --}}
    <section
        class="archive shell section"
        id="projects"
        data-initial-filter="{{ $category }}"
        aria-labelledby="projects-title"
    >
        <div class="section-heading">
            <div>
                <span class="eyebrow">
                    <span class="section-no">02</span>
                    THE COMPLETE COLLECTION
                </span>

                <h2 id="projects-title">
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
                @foreach ($filters as $key => $label)
                    <a
                        href="{{ route(
                            'portfolio.index',
                            $key === 'all' ? [] : ['category' => $key]
                        ) }}#projects"

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
                        <span>{{ $counts[$key] ?? 0 }}</span>
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
                @include('portfolio.partials.archive-row')
            @endforeach
        </div>

        <div class="archive-empty" hidden>
            No projects match your selection.
            Try another filter or save a project with the + button.
        </div>

        <div class="archive-foot">
            <span data-result-count>
                {{ $counts[$category] ?? $projectCount }} PROJECTS
            </span>

            <span>
                <span class="lime-dot" aria-hidden="true"></span>
                SAVED PROJECTS STAY ON THIS DEVICE
            </span>
        </div>
    </section>

    {{-- Community projects --}}
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
                    @include('portfolio.partials.community-card')
                @endforeach

                <div class="collection-panel">
                    <span
                        class="community-icon"
                        aria-hidden="true"
                    >
                        ⌘
                    </span>

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

    {{-- About --}}
    <section
        class="about shell section"
        id="about"
        aria-labelledby="about-title"
    >
        <div class="about-identity">
            <x-brand variant="icon" class="mb-6" />

            <span class="eyebrow">
                MEET THE BUILDER
            </span>

            <h2 id="about-title">
                HUMAN FIRST.<br>
                <span class="serif-neon">
                    DEVELOPER ALWAYS.
                </span>
            </h2>

            <p class="about-name">
                {{ config('portfolio.name', 'Lander') }}

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
                monitoring, financial planning, innovation grants, and
                infrastructure data. I contribute through development,
                interface improvements, workflow fixes, API integration,
                and ongoing maintenance.
            </p>

            <p>
                From national platforms to barangay projects, I care
                about understanding the people behind the process
                and building something that helps.
            </p>

            <div class="skill-tags" aria-label="Technical skills">
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
        aria-labelledby="resume-title"
    >
        <div class="download-panel">
            <div class="download-art" aria-hidden="true">
                <div class="download-sheet">
                    <span>LANDER</span>

                    <strong>
                        MY<br>
                        RÉSUMÉ
                        <span>↗</span>
                    </strong>

                    <div class="paper-lines"></div>

                    <small>
                        EXPERIENCE / PROJECTS / SKILLS
                    </small>
                </div>

                <div class="download-orbit"></div>
            </div>

            <div class="download-copy">
                <span class="eyebrow">
                    THE PERSON BEHIND THE PROJECTS
                </span>

                <h2 id="resume-title">
                    EXPERIENCE.<br>
                    <span class="lime-text">
                        WORTH EXPLORING.
                    </span>
                </h2>

                <p>
                    A closer look at my professional experience,
                    project contributions, education, and technical
                    skills. Download my résumé to read offline.
                </p>

                @if ($resumeAvailable)
                    <a
                        class="btn btn-lime"
                        href="{{ asset('downloads/lander-resume.pdf') }}"
                        download="Lander-Resume.pdf"
                    >
                        Download résumé
                        <span aria-hidden="true">↓</span>
                    </a>

                    <small>
                        PDF FORMAT
                        <span aria-hidden="true">✦</span>
                        PROFESSIONAL RÉSUMÉ
                    </small>
                @else
                    <span
                        class="btn btn-lime"
                        aria-disabled="true"
                    >
                        Résumé available soon
                    </span>

                    <small>
                        MY UPDATED RÉSUMÉ WILL BE AVAILABLE HERE
                    </small>
                @endif
            </div>
        </div>
    </section>
@endsection
