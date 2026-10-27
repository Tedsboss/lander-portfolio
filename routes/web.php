<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/projects/{project}', [PortfolioController::class, 'show'])
    ->where('project', '[a-z0-9-]+')
    ->name('portfolio.show');

Route::get('/sitemap.xml', SitemapController::class)
->name('sitemap');
