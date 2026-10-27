@php
    $archiveScreenshots = config(
        'project_screenshots.' . $project['id'],
        []
    );

    $archiveCover = collect($archiveScreenshots)
        ->keys()
        ->first(fn ($path) => is_file(public_path('images/' . $path)));

    $archiveThumbnail = $archiveCover
    ? 'images/optimized/thumbs/' . $archiveCover . '.webp'
    : null;

    $archiveImageUrl = $archiveCover
        ? asset(
            $archiveThumbnail && is_file(public_path($archiveThumbnail))
                ? $archiveThumbnail
                : 'images/' . $archiveCover
        )
        : null;

    $projectUrl = route('portfolio.show', $project['id']);
@endphp

<article
    class="archive-row archive-row--preview"
    data-project="{{ $project['id'] }}"
    data-category="{{ $project['category'] }}"
    data-search="{{ $project['code'] . ' ' . $project['name'] . ' ' . $project['label'] }}"
    @if ($category !== 'all' && $project['category'] !== $category)
        hidden
    @endif
>
    <span class="row-index">
        {{ str_pad((string) $project['number'], 2, '0', STR_PAD_LEFT) }}
    </span>

    <a
        href="{{ $projectUrl }}"
        class="archive-preview-link"
    >
        <span class="archive-preview-image" aria-hidden="true">
            @if ($archiveCover)
                <img
                    src="{{ $archiveImageUrl }}"
                    alt=""
                    width="128"
                    height="80"
                    loading="lazy"
                    decoding="async"
                >
            @else
                <span class="archive-preview-fallback">
                    {{ $project['code'] }}
                </span>
            @endif
        </span>

        <span class="archive-preview-copy">
            <strong>{{ $project['code'] }}</strong>
            <span>{{ $project['name'] }}</span>
        </span>
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
            href="{{ $projectUrl }}"
            class="row-arrow"
            aria-label="View {{ $project['code'] }} project"
        >
            ↗
        </a>
    </div>
</article>
