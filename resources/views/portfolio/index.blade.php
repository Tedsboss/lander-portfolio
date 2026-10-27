@extends('layouts.app')

@push('styles')
    <style>
        /* Contact section */
        .lander-contact {
            padding-top: 28px;
            padding-bottom: 80px;
            scroll-margin-top: 110px;
        }

        .lander-contact .lander-contact__panel {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
            align-items: center;
            gap: clamp(32px, 5vw, 80px);
            padding: clamp(24px, 5vw, 64px);
            overflow: hidden;
            border: 1px solid rgba(237, 207, 150, 0.22);
            border-radius: 24px;
            background:
                radial-gradient(
                    ellipse at 100% 0%,
                    rgba(152, 82, 214, 0.14),
                    transparent 55%
                ),
                radial-gradient(
                    ellipse at 0% 100%,
                    rgba(237, 207, 150, 0.07),
                    transparent 55%
                ),
                #111116;
        }

        .lander-contact .lander-contact__intro,
        .lander-contact .lander-contact__profiles {
            min-width: 0;
        }

        .lander-contact .lander-contact__eyebrow,
        .lander-contact .lander-contact__profiles-label,
        .lander-contact .lander-contact__label,
        .lander-contact .lander-contact__signature {
            font-family: "IBM Plex Mono", monospace;
            font-size: 10px;
            font-weight: 500;
            line-height: 1.6;
            letter-spacing: 0.14em;
        }

        .lander-contact .lander-contact__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #edcf96;
        }

        .lander-contact .lander-contact__eyebrow > span {
            font-size: 18px;
        }

        .lander-contact .lander-contact__title {
            margin: 20px 0 0;
            color: #f5f2f8;
            font-size: clamp(30px, 3.6vw, 48px);
            font-weight: 600;
            line-height: 1.14;
            letter-spacing: -0.045em;
            text-transform: none;
        }

        .lander-contact .lander-contact__title > span {
            display: block;
            color: #edcf96;
        }

        .lander-contact .lander-contact__description {
            max-width: 440px;
            margin: 20px 0 0;
            color: #b5afc0;
            font-size: 15px;
            line-height: 1.8;
        }

        .lander-contact .lander-contact__email {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid rgba(237, 207, 150, 0.16);
            color: #f5f2f8;
            text-decoration: none;
        }

        .lander-contact .lander-contact__email > span:first-child {
            min-width: 0;
        }

        .lander-contact .lander-contact__label {
            display: block;
            margin-bottom: 8px;
            color: #a59bad;
        }

        .lander-contact .lander-contact__address {
            display: block;
            font-size: clamp(14px, 1.6vw, 19px);
            font-weight: 500;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .lander-contact .lander-contact__arrow {
            display: grid;
            flex: 0 0 44px;
            width: 44px;
            height: 44px;
            place-items: center;
            border: 1px solid rgba(237, 207, 150, 0.3);
            border-radius: 50%;
            color: #edcf96;
            font-size: 22px;
            transition: background 180ms ease, color 180ms ease;
        }

        .lander-contact .lander-contact__email:hover .lander-contact__arrow {
            background: #edcf96;
            color: #111116;
        }

        .lander-contact .lander-contact__profiles-label {
            margin: 0 0 14px;
            color: #a59bad;
        }

        .lander-contact .lander-contact__profile {
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 94px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.025);
            color: #f5f2f8;
            text-decoration: none;
            transition:
                transform 180ms ease,
                border-color 180ms ease,
                background 180ms ease;
        }

        .lander-contact .lander-contact__profile + .lander-contact__profile {
            margin-top: 12px;
        }

        .lander-contact .lander-contact__profile:hover {
            transform: translateY(-3px);
            border-color: rgba(198, 160, 238, 0.5);
            background: rgba(152, 82, 214, 0.08);
        }

        .lander-contact .lander-contact__icon {
            display: grid;
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            place-items: center;
            border: 1px solid rgba(198, 160, 238, 0.18);
            border-radius: 12px;
            background: rgba(152, 82, 214, 0.1);
            color: #d8b8f5;
            font-family: "IBM Plex Mono", monospace;
            font-size: 17px;
            font-weight: 600;
        }

        .lander-contact .lander-contact__profile-copy {
            flex: 1;
            min-width: 0;
        }

        .lander-contact .lander-contact__profile-copy strong {
            display: block;
            font-size: 17px;
            font-weight: 600;
        }

        .lander-contact .lander-contact__profile-copy > span {
            display: block;
            margin-top: 5px;
            color: #b5afc0;
            font-size: 12px;
            line-height: 1.6;
        }

        .lander-contact .lander-contact__profile-arrow {
            flex-shrink: 0;
            color: #c6a0ee;
            font-size: 21px;
        }

        .lander-contact .lander-contact__signature {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 22px;
            color: #a59bad;
            font-size: 9px;
        }

        .lander-contact a:focus-visible {
            outline: 2px solid #edcf96;
            outline-offset: 5px;
        }

        @media (max-width: 767px) {
            .lander-contact {
                padding-bottom: 56px;
            }

            .lander-contact .lander-contact__panel {
                grid-template-columns: minmax(0, 1fr);
                gap: 32px;
                border-radius: 18px;
            }

            .lander-contact .lander-contact__profile {
                gap: 12px;
                padding: 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .lander-contact .lander-contact__profile,
            .lander-contact .lander-contact__arrow {
                transition: none;
            }

            .lander-contact .lander-contact__profile:hover {
                transform: none;
            }
        }
    </style>
@endpush

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

                <span class="signature-line" aria-hidden="true"></span>
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

            <div class="search" role="search" aria-label="Search projects">
                <span aria-hidden="true">⌕</span>

                <input
                    id="project-search"
                    type="search"
                    placeholder="Find a project…"
                    aria-label="Find a project"
                    aria-controls="project-archive-list"
                >

                <button
                    type="button"
                    class="project-search-clear"
                    data-clear-project-search
                    aria-label="Clear project search"
                    hidden
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>

        <div class="archive-header" aria-hidden="true">
            <span>PROJECT / SYSTEM</span>
            <span>DOMAIN</span>
            <span>EXPLORE</span>
        </div>

        <div class="archive-list" id="project-archive-list">
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
                    <span class="community-icon" aria-hidden="true">
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
            <x-brand variant="icon" />

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

    {{-- Contact: separate from the About grid --}}
    <section
        id="contact"
        class="lander-contact shell"
        aria-labelledby="contact-title"
    >
        <div class="lander-contact__panel">
            <div class="lander-contact__intro">
                <span class="lander-contact__eyebrow">
                    <span aria-hidden="true">✦</span>
                    NEXT CONNECTION
                </span>

                <h2 id="contact-title" class="lander-contact__title">
                    Good things start
                    <span>with a conversation.</span>
                </h2>

                <p class="lander-contact__description">
                    Have an idea, a project, or a question?
                    Let’s connect and see what we can build together.
                </p>

                <a
                    class="lander-contact__email"
                    href="mailto:lander.juntila16@gmail.com"
                >
                    <span>
                        <span class="lander-contact__label">
                            EMAIL ME
                        </span>

                        <span class="lander-contact__address">
                            lander.juntila16@gmail.com
                        </span>
                    </span>

                    <span
                        class="lander-contact__arrow"
                        aria-hidden="true"
                    >
                        ↗
                    </span>
                </a>
                <div class="contact-email-tools">
                    <button
                        type="button"
                        class="contact-copy-email"
                        data-copy-email="lander.juntila16@gmail.com"
                        aria-describedby="contact-copy-status"
                    >
                        Copy email address
                    </button>

                    <span
                        id="contact-copy-status"
                        class="contact-copy-status"
                        role="status"
                        aria-live="polite"
                        aria-atomic="true"
                    ></span>
                </div>
            </div>

            <div
                class="lander-contact__profiles"
                role="group"
                aria-label="Professional profiles"
            >
                <p class="lander-contact__profiles-label">
                    FIND ME ONLINE
                </p>

                <a
                    class="lander-contact__profile"
                    href="https://github.com/Tedsboss"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Tedsboss on GitHub, opens in a new tab"
                >
                    <span
                        class="lander-contact__icon"
                        aria-hidden="true"
                    >
                        &lt;/&gt;
                    </span>

                    <span class="lander-contact__profile-copy">
                        <strong>GitHub</strong>
                        <span>Code, projects, and experiments</span>
                    </span>

                    <span
                        class="lander-contact__profile-arrow"
                        aria-hidden="true"
                    >
                        ↗
                    </span>
                </a>

                <a
                    class="lander-contact__profile"
                    href="https://www.linkedin.com/in/lander-ortega/"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Marlon Lander Ortega on LinkedIn, opens in a new tab"
                >
                    <span
                        class="lander-contact__icon"
                        aria-hidden="true"
                    >
                        in
                    </span>

                    <span class="lander-contact__profile-copy">
                        <strong>LinkedIn</strong>
                        <span>
                            Experience and professional connections
                        </span>
                    </span>

                    <span
                        class="lander-contact__profile-arrow"
                        aria-hidden="true"
                    >
                        ↗
                    </span>
                </a>

                <div class="lander-contact__signature">
                    <span aria-hidden="true">✧</span>
                    BASED IN THE PHILIPPINES
                </div>
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
                    Explore my professional experience, project contributions,
                    education, and technical skills. View my résumé online
                    or download a copy to read offline.
                </p>

            @if ($resumeAvailable)
                <div class="resume-actions">
                    <a
                        class="btn btn-lime"
                        href="{{ asset('downloads/lander-resume.pdf') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="View Lander’s résumé PDF in a new tab"
                    >
                        View résumé
                        <span aria-hidden="true">↗</span>
                    </a>

                    <a
                        class="text-link resume-download-link"
                        href="{{ asset('downloads/lander-resume.pdf') }}"
                        download="Lander-Resume.pdf"
                    >
                        Download PDF
                        <span aria-hidden="true">↓</span>
                    </a>
                </div>

                <small>
                    PDF FORMAT
                    <span aria-hidden="true">✦</span>
                    VIEW ONLINE OR SAVE A COPY
                </small>
            @else
                <span class="resume-unavailable">
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
