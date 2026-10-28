<?php

namespace Tests\Feature;

use Tests\TestCase;

class PortfolioPagesTest extends TestCase
{
    public function test_homepage_displays_the_main_sections(): void
    {
        $response = $this->get(route('portfolio.index'));

        $response->assertOk();

        foreach ([
            'showcase',
            'projects',
            'community',
            'about',
            'contact',
            'download',
        ] as $section) {
            $response->assertSee(
                'id="' . $section . '"',
                false
            );
        }
    }

    public function test_every_configured_project_page_loads(): void
    {
        $projects = config('portfolio.projects', []);

        $this->assertNotEmpty(
            $projects,
            'The portfolio project configuration is empty.'
        );

        foreach ($projects as $project) {
            $response = $this->get(
                route('portfolio.show', $project['id'])
            );

            $this->assertSame(
                200,
                $response->getStatusCode(),
                'Project page failed: ' . $project['id']
            );

            $response->assertSeeText($project['code']);
            $response->assertSeeText($project['name']);
        }
    }

    public function test_sitemap_contains_homepage_and_project_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();

        $response->assertHeader(
            'Content-Type',
            'application/xml; charset=UTF-8'
        );

        $urls = [
            route('portfolio.index'),
        ];

        foreach (config('portfolio.projects', []) as $project) {
            $urls[] = route(
                'portfolio.show',
                $project['id']
            );
        }

        foreach ($urls as $url) {
            $escapedUrl = htmlspecialchars(
                $url,
                ENT_XML1 | ENT_QUOTES,
                'UTF-8'
            );

            $response->assertSee(
                '<loc>' . $escapedUrl . '</loc>',
                false
            );
        }
    }

    public function test_unknown_project_returns_not_found(): void
    {
        $this->get(
            route('portfolio.show', 'nonexistent-project-check')
        )->assertNotFound();
    }

    public function test_unknown_page_displays_the_custom_404(): void
    {
        $response = $this->get(
            '/nonexistent-page-check'
        );

        $response->assertNotFound();
        $response->assertSeeText('Lost in space?');
    }
}
