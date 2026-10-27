@php
    $screenshots = collect(
        config('project_screenshots.' . $project['id'], [])
    )
        ->filter(
            fn ($caption, $path) =>
                is_file(public_path('images/' . $path))
        )
        ->map(function ($caption, $path) {
            $previewPath = 'images/optimized/cards/' . $path . '.webp';

            return [
                'src' => asset(
                    is_file(public_path($previewPath))
                        ? $previewPath
                        : 'images/' . $path
                ),
                'caption' => $caption,
            ];
        })
        ->values();

    $cover = $screenshots->first();

    $theme = $project['theme']
        ?? ($project['id'] === 'ppms' ? 'blue' : 'lime');
@endphp

<article
    class="showcase-card theme-{{ $theme }}"
    aria-label="{{ $project['code'] }} featured project"
>
    @if ($cover)
        <a
            class="card-visual card-visual--screenshot"
            href="{{ route('portfolio.show', $project['id']) }}"
            aria-label="Explore {{ $project['code'] }} screenshots and project details"
        >
            <img
                class="project-cover-image"
                src="{{ $cover['src'] }}"
                alt="{{ $project['code'] }} — {{ $cover['caption'] }}"
                loading="lazy"
                decoding="async"
            >

            <span class="project-cover-badge">
                {{ $screenshots->count() }} SCREENSHOTS
            </span>
        </a>
    @else
        <div class="card-visual" aria-hidden="true">
            <div class="cover-grid"></div>

            <span class="cover-meta">
                FEATURED SYSTEM /
                {{ str_pad($project['number'], 2, '0', STR_PAD_LEFT) }}
            </span>

            <span class="cover-cross">+</span>

            <strong class="cover-code">
                {{ $project['code'] }}
            </strong>

            <span class="cover-foot">
                CONCEPTUAL SYSTEM ARTWORK
                <span>↗</span>
            </span>
        </div>
    @endif

    <div class="showcase-card-body">
        <div class="card-category">
            <span>{{ $project['label'] }}</span>

            <span>
                {{ str_pad($project['number'], 2, '0', STR_PAD_LEFT) }}
            </span>
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
