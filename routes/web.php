<?php

use App\Http\Controllers\Admin\CitizenReportController as AdminCitizenReportController;
use App\Http\Controllers\Admin\WeatherAlertController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pengamat\ClimateRecordController;
use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------------------------
// Public routes — no auth required
// ---------------------------------------------------------------------------

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/statistik', [PublicController::class, 'statistics'])->name('statistik');
Route::get('/laporkan', [PublicController::class, 'report'])->name('laporkan');
Route::get('/peringatan', [PublicController::class, 'alerts'])->name('peringatan');
Route::post('/laporan-warga', [PublicController::class, 'storeCitizenReport'])->name('citizen-reports.store');
Route::view('/offline', 'offline')->name('offline');

// ---------------------------------------------------------------------------
// Auth routes
// ---------------------------------------------------------------------------

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ---------------------------------------------------------------------------
// Pengamat routes — auth + role:pengamat
// ---------------------------------------------------------------------------

Route::middleware(['auth', 'role:pengamat'])
    ->prefix('pengamat')
    ->name('pengamat.')
    ->group(function (): void {
        Route::get('/', fn () => view('pengamat.dashboard'))->name('dashboard');
        Route::get('/iklim', [ClimateRecordController::class, 'index'])->name('climate-records.index');
        Route::post('/iklim', [ClimateRecordController::class, 'store'])->name('climate-records.store');
    });

// ---------------------------------------------------------------------------
// Admin routes — auth + role:admin
// ---------------------------------------------------------------------------

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/laporan', [AdminCitizenReportController::class, 'index'])->name('citizen-reports.index');
        Route::patch('/laporan/{report}/status', [AdminCitizenReportController::class, 'updateStatus'])->name('citizen-reports.update-status');
        Route::post('/peringatan', [WeatherAlertController::class, 'trigger'])->name('weather-alerts.trigger');
    });
