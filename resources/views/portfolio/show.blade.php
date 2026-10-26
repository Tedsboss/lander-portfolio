@extends('layouts.app')

@section('title', $project['code'].' — '.config('portfolio.name'))

@section('content')
<article class="detail shell">
    <a href="{{ route('portfolio.index') }}#projects" class="back-link">← BACK TO ALL PROJECTS</a>
    <div class="detail-grid">
        <div class="detail-copy">
            <span class="eyebrow"><span class="section-no">{{ str_pad((string) $project['number'], 2, '0', STR_PAD_LEFT) }}</span> {{ config('portfolio.categories.'.$project['category']) }} / PROJECT EXPERIENCE</span>
            <p class="detail-code">{{ $project['code'] }}</p>
            <h1>{{ $project['name'] }}</h1>
            <div class="detail-tags">
                @foreach (array_unique(array_filter([$project['label'], $project['role'] ?? null, $project['status'] ?? null])) as $tag)
                    <span>{{ $tag }}</span>
                @endforeach
            </div>
            <p>{{ $project['description'] }}</p>
            @isset($project['contribution'])
                <h2>My contribution</h2>
                <p>{{ $project['contribution'] }}</p>
            @endisset
            <div class="detail-actions">
                @isset($project['url'])
                    <a class="text-link" href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">Visit public website ↗</a>
                @endisset
                <button class="save-button" data-save="{{ $project['id'] }}" aria-label="Save {{ $project['code'] }}" aria-pressed="false">+</button>
                <button class="share-button" data-share="{{ route('portfolio.show', $project['id']) }}" data-share-name="{{ $project['code'] }}" aria-label="Share {{ $project['code'] }} project">↗ Share project</button>
            </div>
        </div>
        <aside>
            <div class="detail-art"><span>{{ $project['code'] }}</span></div>
            <p class="detail-note">CONCEPTUAL PROJECT GRAPHIC</p>
            <div class="detail-meta">
                <span class="eyebrow">PROJECT CONTEXT</span>
                <dl>
                    <div><dt>Domain</dt><dd>{{ $project['label'] }}</dd></div>
                    @isset($project['role'])<div><dt>Involvement</dt><dd>{{ $project['role'] }}</dd></div>@endisset
                    @isset($project['status'])<div><dt>Status</dt><dd>{{ $project['status'] }}</dd></div>@endisset
                </dl>
            </div>
        </aside>
    </div>
</article>
@endsection
