<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HafalanController;
use App\Http\Controllers\VoiceSubmissionController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes - Hafalan Santri MAKN Ende
|--------------------------------------------------------------------------
*/

// Root route - Landing page for SEO
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Protected routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Voice submission routes
    Route::get('/voice-submission', [VoiceSubmissionController::class, 'index'])->name('voice.index');
    Route::get('/voice-submission/{id}', [VoiceSubmissionController::class, 'show'])->name('voice.show');
    
    // Routes untuk santri
    Route::middleware('role:santri')->group(function () {
        Route::post('/voice-submission', [VoiceSubmissionController::class, 'store'])->name('voice.store');
        Route::delete('/voice-submission/{id}', [VoiceSubmissionController::class, 'destroy'])->name('voice.destroy');
    });
    
    // Routes untuk ustad dan admin
    Route::middleware('role:ustad,admin')->group(function () {
        // Voice submission review
        Route::patch('/voice-submission/{id}/review', [VoiceSubmissionController::class, 'review'])->name('voice.review');

        // Hafalan management
        Route::resource('hafalan', HafalanController::class);

        // Santri management
        Route::resource('santri', SantriController::class);
        Route::patch('/santri/{id}/reset-password', [SantriController::class, 'resetPassword'])->name('santri.reset-password');

        // Export routes
        Route::get('/export', [ExportController::class, 'index'])->name('export.index');
        Route::get('/export/santri', [ExportController::class, 'exportSantri'])->name('export.santri');
        Route::get('/export/submissions', [ExportController::class, 'exportSubmissions'])->name('export.submissions');
        Route::get('/export/progress', [ExportController::class, 'exportProgress'])->name('export.progress');
        Route::get('/export/statistik', [ExportController::class, 'exportStatistik'])->name('export.statistik');
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/users', [AdminController::class, 'users'])->name('users.index');
            Route::patch('/users/{id}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
            Route::patch('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
            Route::patch('/users/{id}/reset-verification', [AdminController::class, 'resetVerification'])->name('users.reset-verification');
        });
    });
});