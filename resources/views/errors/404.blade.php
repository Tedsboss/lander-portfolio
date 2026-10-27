@extends('layouts.app')

@section('title', 'Page not found — Lander')

@push('styles')
    <style>
        .lost-page {
            display: grid;
            min-height: 70vh;
            place-items: center;
            padding-top: 64px;
            padding-bottom: 80px;
        }

        .lost-page__panel {
            width: 100%;
            max-width: 760px;
            padding: clamp(28px, 6vw, 72px);
            border: 1px solid rgba(237, 207, 150, 0.22);
            border-radius: 24px;
            background:
                radial-gradient(
                    ellipse at 50% 0%,
                    rgba(152, 82, 214, 0.16),
                    transparent 65%
                ),
                #111116;
            text-align: center;
        }

        .lost-page__emblem {
            display: block;
            width: 64px;
            height: 64px;
            margin: 0 auto 24px;
        }

        .lost-page__label {
            margin: 0;
            color: #c6a0ee;
            font-family: "IBM Plex Mono", monospace;
            font-size: 11px;
            letter-spacing: 0.16em;
        }

        .lost-page__code {
            margin: 12px 0;
            color: #edcf96;
            font-size: clamp(88px, 18vw, 160px);
            font-weight: 600;
            line-height: 1;
            letter-spacing: -0.06em;
        }

        .lost-page__title {
            margin: 20px 0 0;
            color: #f5f2f8;
            font-size: clamp(26px, 4vw, 40px);
            font-weight: 600;
            line-height: 1.2;
            letter-spacing: -0.03em;
        }

        .lost-page__description {
            max-width: 430px;
            margin: 18px auto 0;
            color: #b5afc0;
            font-size: 15px;
            line-height: 1.8;
        }

        .lost-page__actions {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 16px 24px;
            margin-top: 32px;
        }

        .lost-page__actions .btn,
        .lost-page__actions .text-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 44px;
            margin: 0;
        }

        .lost-page__actions a:focus-visible {
            outline: 2px solid #edcf96;
            outline-offset: 5px;
        }

        @media (max-width: 480px) {
            .lost-page__actions {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endpush

@section('content')
    <section class="lost-page shell" aria-labelledby="lost-page-title">
        <div class="lost-page__panel">
            <img
                class="lost-page__emblem"
                src="{{ asset('favicon.svg') }}"
                alt=""
                width="64"
                height="64"
            >

            <p class="lost-page__label">
                COORDINATES NOT FOUND
            </p>

            <p class="lost-page__code" aria-hidden="true">
                404
            </p>

            <h1 id="lost-page-title" class="lost-page__title">
                Lost in space?
            </h1>

            <p class="lost-page__description">
                We couldn’t find this page. The link may be outdated,
                or the address may have been typed incorrectly.
                Let’s get you back to familiar territory.
            </p>

            <div class="lost-page__actions">
                <a
                    class="btn btn-lime"
                    href="{{ route('portfolio.index') }}"
                >
                    Return home
                    <span aria-hidden="true">↗</span>
                </a>

                <a
                    class="text-link"
                    href="{{ route('portfolio.index') }}#projects"
                >
                    Explore projects
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>
@endsection
