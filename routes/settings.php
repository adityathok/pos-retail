<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');

    Route::put('settings/password', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    // General Settings Routes
    Route::get('settings/general', function () {
        return Inertia::render('settings/General');
    })->name('settings.general');
    
    // API Routes for Settings
    Route::prefix('api/settings')->group(function () {
        Route::get('general', [SettingController::class, 'general'])->name('api.settings.general');
        Route::put('general', [SettingController::class, 'updateGeneral'])->name('api.settings.general.update');
        Route::get('{key}', [SettingController::class, 'getSetting'])->name('api.settings.get');
        Route::put('{key}', [SettingController::class, 'setSetting'])->name('api.settings.set');
    });

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');
});
