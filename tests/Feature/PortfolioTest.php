<?php

namespace Tests\Feature;

use Tests\TestCase;

class PortfolioTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_home_renders_every_project_from_the_catalog(): void
    {
        $response = $this->get('/')->assertOk();
        foreach (config('portfolio.projects') as $project) {
            $response->assertSee(route('portfolio.show', $project['id']), false);
        }
    }

    public function test_community_filter_excludes_other_project_cards(): void
    {
        $this->get('/?category=community')->assertOk()
            ->assertSee(route('portfolio.show', 'tangus'), false)
            ->assertSee(route('portfolio.show', 'sagad'), false)
            ->assertViewHas('category', 'community')
            ->assertViewHas('projects', fn ($projects) => $projects->pluck('id')->all() === ['tangus', 'sagad']);
    }

    public function test_maintenance_filter_only_lists_timta(): void
    {
        $this->get('/?category=maintenance')->assertOk()
            ->assertSee(route('portfolio.show', 'timta'), false)
            ->assertViewHas('category', 'maintenance')
            ->assertViewHas('projects', fn ($projects) => $projects->pluck('id')->all() === ['timta']);
    }

    public function test_all_projects_have_accessible_detail_pages(): void
    {
        foreach (config('portfolio.projects') as $project) {
            $this->get(route('portfolio.show', $project['id']))->assertOk()->assertSee($project['name']);
        }
    }

    public function test_sagad_is_explicitly_in_progress(): void
    {
        $this->get('/projects/sagad')->assertOk()->assertSee('In progress');
    }

    public function test_sds_preserves_the_supplied_public_link(): void
    {
        $this->get('/projects/sds')->assertOk()->assertSee('href="https://socdevdata.depdev.gov.ph/"', false);
    }

    public function test_unknown_project_and_invalid_categories_return_not_found(): void
    {
        $this->get('/projects/unknown')->assertNotFound();
        $this->get('/?category=unknown')->assertNotFound();
        $this->get('/?category[]=community')->assertNotFound();
    }
}
