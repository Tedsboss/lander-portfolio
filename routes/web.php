<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/projects/{project}', [PortfolioController::class, 'show'])
    ->where('project', '[a-z0-9-]+')
    ->name('portfolio.show');
