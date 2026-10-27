@extends('layouts.app')

@section('title', $project['code'] . ' — ' . config('portfolio.name'))

@section('description', $project['description'])

@section('content')
    {{-- Keep your existing project details, gallery, and navigation here. --}}
    @php
        $screenshots = collect(
            config('project_screenshots.'.$project['id'], [])
        )
            ->filter(
                fn ($caption, $path) => is_file(
                    public_path('images/'.$path)
                )
            )
            ->map(
                fn ($caption, $path) => [
                    'src' => asset('images/'.$path),
                    'caption' => $caption,
                ]
            )
            ->values();

        $firstScreenshot = $screenshots->first();

        $tags = array_unique(array_filter([
            $project['label'],
            $project['role'] ?? null,
            $project['status'] ?? null,
        ]));
    @endphp

    <article class="detail shell">
        <a
            href="{{ route('portfolio.index') }}#projects"
            class="back-link"
        >
            ← BACK TO ALL PROJECTS
        </a>

        <div class="detail-grid">
            <div class="detail-copy">
                <span class="eyebrow">
                    <span class="section-no">
                        {{ str_pad($project['number'], 2, '0', STR_PAD_LEFT) }}
                    </span>

                    {{ config('portfolio.categories.'.$project['category']) }}
                    / PROJECT EXPERIENCE
                </span>

                <p class="detail-code">
                    {{ $project['code'] }}
                </p>

                <h1>{{ $project['name'] }}</h1>

                <div class="detail-tags">
                    @foreach ($tags as $tag)
                        <span>{{ $tag }}</span>
                    @endforeach
                </div>

                <p>{{ $project['description'] }}</p>

                @if (!empty($project['contribution']))
                    <h2>My contribution</h2>
                    <p>{{ $project['contribution'] }}</p>
                @endif

                <div class="detail-actions">
                    @if (!empty($project['url']))
                        <a
                            class="text-link"
                            href="{{ $project['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Open {{ $project['code'] }} website in a new tab"
                        >
                            Open website
                            <span aria-hidden="true">↗</span>
                        </a>
                    @endif

                    <button
                        type="button"
                        class="save-button"
                        data-save="{{ $project['id'] }}"
                        aria-label="Save {{ $project['code'] }}"
                        aria-pressed="false"
                    >
                        +
                    </button>

                    <button
                        type="button"
                        class="share-button"
                        data-share="{{ route('portfolio.show', $project['id']) }}"
                        data-share-name="{{ $project['code'] }}"
                        aria-label="Share {{ $project['code'] }} project"
                    >
                        ↗ Share project
                    </button>
                </div>
            </div>

            <aside>
                @if ($firstScreenshot)
                    <div
                        class="project-gallery"
                        data-project-gallery
                        data-project-name="{{ $project['code'] }}"
                    >
                        <figure class="project-gallery-main">
                            <a
                                class="project-gallery-open"
                                href="{{ $firstScreenshot['src'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                data-gallery-open
                                aria-label="Enlarge screenshot"
                            >
                                <img
                                    src="{{ $firstScreenshot['src'] }}"
                                    alt="{{ $project['code'] }} — {{ $firstScreenshot['caption'] }}"
                                    data-gallery-image
                                    decoding="async"
                                >

                                <span class="project-gallery-expand">
                                    Enlarge ↗
                                </span>
                            </a>

                            <figcaption
                                class="project-gallery-caption"
                                data-gallery-caption
                                aria-live="polite"
                            >
                                {{ $firstScreenshot['caption'] }}
                            </figcaption>
                        </figure>

                        <div
                            class="project-gallery-thumbnails"
                            aria-label="Project screenshots"
                        >
                            @foreach ($screenshots as $shot)
                                <a
                                    class="project-gallery-thumbnail"
                                    href="{{ $shot['src'] }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    data-gallery-shot
                                    data-caption="{{ $shot['caption'] }}"
                                    aria-label="View {{ $shot['caption'] }}"

                                    @if ($loop->first)
                                        aria-current="true"
                                    @endif
                                >
                                    <img
                                        src="{{ $shot['src'] }}"
                                        alt=""
                                        loading="lazy"
                                        decoding="async"
                                    >

                                    <span>{{ $shot['caption'] }}</span>
                                </a>
                            @endforeach
                        </div>

                        <dialog
                            class="project-lightbox"
                            data-project-lightbox
                            aria-label="{{ $project['code'] }} screenshot viewer"
                        >
                            <div class="project-lightbox-toolbar">
                                <span data-lightbox-count aria-live="polite">
                                    1 / {{ $screenshots->count() }}
                                </span>

                                <button
                                    type="button"
                                    class="screenshot-button"
                                    data-lightbox-close
                                    aria-label="Close screenshot viewer"
                                >
                                    ×
                                </button>
                            </div>

                            <figure>
                                <img
                                    data-lightbox-image
                                    alt=""
                                >

                                <figcaption
                                    data-lightbox-caption
                                    aria-live="polite"
                                ></figcaption>
                            </figure>

                            <div class="project-lightbox-navigation">
                                <button
                                    type="button"
                                    class="screenshot-button"
                                    data-lightbox-prev
                                    aria-label="Previous screenshot"
                                >
                                    ←
                                </button>

                                <button
                                    type="button"
                                    class="screenshot-button"
                                    data-lightbox-next
                                    aria-label="Next screenshot"
                                >
                                    →
                                </button>
                            </div>
                        </dialog>
                    </div>
                @else
                    <div class="detail-art" aria-hidden="true">
                        <span>{{ $project['code'] }}</span>
                    </div>

                    <p class="detail-note">
                        CONCEPTUAL PROJECT GRAPHIC
                    </p>
                @endif

                <div class="detail-meta">
                    <span class="eyebrow">
                        PROJECT CONTEXT
                    </span>

                    <dl>
                        <div>
                            <dt>Domain</dt>
                            <dd>{{ $project['label'] }}</dd>
                        </div>

                        @if (!empty($project['role']))
                            <div>
                                <dt>Involvement</dt>
                                <dd>{{ $project['role'] }}</dd>
                            </div>
                        @endif

                        @if (!empty($project['status']))
                            <div>
                                <dt>Status</dt>
                                <dd>{{ $project['status'] }}</dd>
                            </div>
                        @endif

                        @if ($screenshots->isNotEmpty())
                            <div>
                                <dt>Screenshots</dt>
                                <dd>{{ $screenshots->count() }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </aside>
        </div>
        @include('portfolio.partials.project-navigation')
    </article>
@endsection@endsection
