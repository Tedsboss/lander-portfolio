@php
    $navigationProjects = collect(config('portfolio.projects', []))
        ->values();

    $currentProjectIndex = $navigationProjects->search(
        fn ($item) => $item['id'] === $project['id']
    );

    $previousProject = $currentProjectIndex !== false
        && $currentProjectIndex > 0
            ? $navigationProjects->get($currentProjectIndex - 1)
            : null;

    $nextProject = $currentProjectIndex !== false
        ? $navigationProjects->get($currentProjectIndex + 1)
        : null;
@endphp

<nav class="project-pagination" aria-label="Project navigation">
    <div class="project-pagination__heading">
        <span>CONTINUE EXPLORING</span>

        <a href="{{ route('portfolio.index') }}#projects">
            All projects
            <span aria-hidden="true">↗</span>
        </a>
    </div>

    <div class="project-pagination__grid">
        @if ($previousProject)
            <a
                class="project-pagination__card"
                href="{{ route('portfolio.show', $previousProject['id']) }}"
                rel="prev"
            >
                <span class="project-pagination__direction">
                    <span aria-hidden="true">←</span>
                    Previous project
                </span>

                <strong>{{ $previousProject['code'] }}</strong>

                <span class="project-pagination__name">
                    {{ $previousProject['name'] }}
                </span>
            </a>
        @endif

        @if ($nextProject)
            <a
                class="project-pagination__card project-pagination__card--next"
                href="{{ route('portfolio.show', $nextProject['id']) }}"
                rel="next"
            >
                <span class="project-pagination__direction">
                    Next project
                    <span aria-hidden="true">→</span>
                </span>

                <strong>{{ $nextProject['code'] }}</strong>

                <span class="project-pagination__name">
                    {{ $nextProject['name'] }}
                </span>
            </a>
        @endif
    </div>
</nav>
