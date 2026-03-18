<?php

use App\Livewire\About\AboutManager;
use App\Livewire\Dashboard;
use App\Livewire\HomePage;
use App\Livewire\Public\ProjectShow;
use App\Livewire\Resume\ResumeManager;
use App\Livewire\Skills\SkillManager;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public routes
Route::get('/', HomePage::class)->name('home');
Route::get('/project/{slug}', ProjectShow::class)->name('project.show');

// Dashboard CMS — protected
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/dashboard/skills', SkillManager::class)->name('skills');
    Route::get('/dashboard/about', AboutManager::class)->name('about');
    Route::get('/dashboard/resume', ResumeManager::class)->name('resume');

    Route::post('/dashboard/skills/reorder', function (Request $request) {
        $ids = $request->input('ids', []);
        foreach ($ids as $order => $id) {
            Skill::where('id', $id)->update(['sort_order' => $order]);
        }

        return response()->json(['ok' => true]);
    })->name('skills.reorder');
});

require __DIR__.'/settings.php';
