<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [RoleController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Role management routes (Owner only)
Route::middleware(['auth', 'role:Owner'])->prefix('admin')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles');
    Route::post('/roles/assign', [RoleController::class, 'assignRole'])->name('admin.roles.assign');
    Route::delete('/roles/remove', [RoleController::class, 'removeRole'])->name('admin.roles.remove');
});

// API routes for role management
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/users-by-role', [RoleController::class, 'getUsersByRole'])->name('api.users.by-role');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
