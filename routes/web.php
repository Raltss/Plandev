<?php

use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Settings routes using Livewire
Route::middleware(['auth'])->prefix('settings')->group(function () {
    Route::get('/profile', \App\Livewire\Settings\Profile::class)->name('settings.profile');
    Route::get('/password', \App\Livewire\Settings\Password::class)->name('settings.password');
    Route::get('/two-factor', \App\Livewire\Settings\TwoFactor::class)->name('two-factor.show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/boards', [BoardController::class, 'index'])
        ->name('boards.index');
    Route::get('/boards/{board}', [BoardController::class, 'show'])
        ->name('boards.show');
});

require __DIR__.'/auth.php';
