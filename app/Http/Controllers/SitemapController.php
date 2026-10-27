<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            route('portfolio.index'),
        ])
            ->merge(
                collect(config('portfolio.projects', []))
                    ->map(
                        fn (array $project) => route(
                            'portfolio.show',
                            $project['id']
                        )
                    )
            )
            ->unique()
            ->values();

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header(
                'Content-Type',
                'application/xml; charset=UTF-8'
            );
    }
}
