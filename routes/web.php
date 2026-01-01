<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/boards', [BoardController::class, 'index'])
        ->name('boards.index');
});

require __DIR__.'/auth.php';
