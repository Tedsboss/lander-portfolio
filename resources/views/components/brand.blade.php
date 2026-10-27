@props(['variant' => 'nav'])

@if ($variant === 'hero')
    <figure
        {{ $attributes->class([
            'celestial-brand',
            'celestial-brand--hero',
        ]) }}
    >
    <picture class="celestial-brand__picture">
        @if (is_file(public_path('images/lander-celestial.webp')))
            <source
                srcset="{{ asset('images/lander-celestial.webp') }}"
                type="image/webp"
            >
        @endif

        <img
            class="celestial-brand__art"
            src="{{ asset('images/lander-celestial.png') }}"
            alt="Lander celestial logo with a purple amethyst, gold navigation star, and Aquarius waves"
            width="1536"
            height="1024"
            fetchpriority="high"
            decoding="async"
        >
    </picture>
    </figure>
@else
    <a
        href="{{ route('portfolio.index') }}"
        aria-label="Lander — home"
        {{ $attributes->class([
            'celestial-brand',
            'celestial-brand--'.$variant,
        ]) }}
    >
        <img
            class="celestial-brand__emblem"
            src="{{ asset('favicon.svg') }}"
            alt=""
            width="48"
            height="48"
            decoding="async"
        >

        @if ($variant !== 'icon')
            <span class="celestial-brand__identity">
                <span class="celestial-brand__name">
                    LANDER
                </span>

                <span class="celestial-brand__role">
                    SOFTWARE DEVELOPER
                </span>
            </span>
        @endif
    </a>
@endif
