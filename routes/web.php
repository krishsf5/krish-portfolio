<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Skills\SkillManager;
use App\Livewire\About\AboutManager;
use App\Livewire\HomePage;
use App\Livewire\Resume\ResumeManager;
// use App\Livewire\Public\ProjectShow;

//public routes
Route::get('/', HomePage::class)->name('home');
// Route::get('/project/{slug}', ProjectShow::class)->name('project.show');

// Dashboard CMS — protected
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/dashboard/skills', SkillManager::class)->name('skills');
    Route::get('/dashboard/about', AboutManager::class)->name('about');
    Route::get('/dashboard/resume', ResumeManager::class)->name('resume');
});

require __DIR__.'/settings.php';
