<?php

use App\Http\Controllers\Auth\ApiLoginController;
use App\Livewire\About\AboutManager;
use App\Livewire\Dashboard;
use App\Livewire\HomePage;
use App\Livewire\Inquiries\InquiryManager;
use App\Livewire\Public\ProjectShow;
use App\Livewire\Resume\ResumeManager;
use App\Livewire\Skills\SkillManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', HomePage::class)->name('home');
Route::get('/project/{slug}', ProjectShow::class)->name('project.show');

// ─── Auth Routes (no DB — calls backend API) ──────────────────────────────────
Route::get('/login', [ApiLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ApiLoginController::class, 'login'])->name('login.store');
Route::post('/logout', [ApiLoginController::class, 'logout'])->name('logout');

// ─── Dashboard CMS — protected by session token ───────────────────────────────
Route::middleware('api.auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/dashboard/skills', SkillManager::class)->name('skills');
    Route::get('/dashboard/about', AboutManager::class)->name('about');
    Route::get('/dashboard/resume', ResumeManager::class)->name('resume');
    Route::get('/dashboard/inquiries', InquiryManager::class)->name('inquiries');

    // Skill reorder (AJAX from drag-drop)
    Route::post('/dashboard/skills/reorder', function (Request $request) {
        $ids = $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        $response = \App\Services\ApiClient::post('/admin/skills/reorder', ['ids' => $ids]);

        if ($response->successful()) {
            Cache::forget('public.skills');
        }

        return response()->json(['ok' => $response->successful()]);
    })->name('skills.reorder');
});

// ─── Settings (appearance, profile, security — kept minimal) ─────────────────
require __DIR__.'/settings.php';
