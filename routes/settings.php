<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['api.auth'])->group(function () {
    Route::redirect('settings', '/dashboard/about');
    Route::redirect('settings/profile', '/dashboard/about')->name('profile.edit');
    Route::redirect('settings/appearance', '/dashboard')->name('appearance.edit');
    Route::redirect('settings/security', '/dashboard')->name('security.edit');
});
