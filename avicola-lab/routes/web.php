<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GranjaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\PruebaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('granjas', GranjaController::class);
Route::resource('lotes', LoteController::class);
Route::resource('pruebas', PruebaController::class);
// Reportes
Route::prefix('reportes')->group(function () {
    Route::get('/dashboard-avanzado', [App\Http\Controllers\ReporteController::class, 'dashboardAvanzado'])->name('reportes.dashboard-avanzado');
    Route::get('/comparativas-avanzadas', [App\Http\Controllers\ReporteController::class, 'comparativasAvanzadas'])->name('reportes.comparativas-avanzadas');
});

