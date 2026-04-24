<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\DashboardController;

// Landing page pública
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Redirigir /welcome a landing
Route::view('/welcome', 'landing')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas de Donaciones
    Route::prefix('donaciones')->group(function () {
        Route::view('', 'pages.donaciones.lista')->name('donations.list');
        Route::view('gestionar', 'pages.donaciones.gestionar')->name('donations.manage');
        Route::view('historial', 'pages.donaciones.historial')->name('donations.history');
    });
});

require __DIR__.'/settings.php';
