<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    private function projects(): Collection
    {
        return collect(config('portfolio.projects', []))
            ->values()
            ->map(
                fn (array $project, int $index) => $project + [
                    'number' => $index + 1,
                ]
            );
    }

    public function index(Request $request): View
    {
        $categories = config('portfolio.categories', []);

        $category = $request->query('category', 'all');

        $allowedCategories = [
            'all',
            ...array_keys($categories),
        ];

        abort_unless(
            is_string($category)
                && in_array($category, $allowedCategories, true),
            404
        );

        $allProjects = $this->projects();

        $projects = $category === 'all'
            ? $allProjects
            : $allProjects
                ->where('category', $category)
                ->values();

        $counts = [
            'all' => $allProjects->count(),
        ];

        foreach (array_keys($categories) as $key) {
            $counts[$key] = $allProjects
                ->where('category', $key)
                ->count();
        }

        return view('portfolio.index', [
            'allProjects' => $allProjects,
            'projects' => $projects,
            'featured' => $projects
                ->where('featured', true)
                ->values(),
            'otherProjects' => $projects
                ->reject(
                    fn (array $project) => $project['featured'] ?? false
                )
                ->values(),
            'category' => $category,
            'counts' => $counts,
        ]);
    }

    public function show(string $project): View
    {
        $selected = $this->projects()
            ->firstWhere('id', $project);

        abort_if($selected === null, 404);

        return view('portfolio.show', [
            'project' => $selected,
        ]);
    }
}
