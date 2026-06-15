<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeternakController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fitur', function () {
    return view('fitur');
})->name('fitur');


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/activities', [DashboardController::class, 'activities'])->name('activities.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Role: Owner & Staff can access Peternak, Sheep, and Cage
    Route::middleware('role:owner')->group(function () {
        Route::resource('peternak', PeternakController::class)->except(['show']);
        Route::resource('sheep', App\Http\Controllers\SheepController::class)->except(['show']);
        Route::post('/sheep/export', [App\Http\Controllers\SheepController::class, 'exportRequest'])->name('sheep.export');
        Route::get('/sheep/download-export', [App\Http\Controllers\SheepController::class, 'downloadExport'])->name('sheep.download');
        Route::resource('cage', App\Http\Controllers\CageController::class)->except(['show']);
        Route::get('/health-records', [App\Http\Controllers\HealthRecordController::class, 'index'])->name('health-records.index');
        Route::get('/health-records/{sheep}', [App\Http\Controllers\HealthRecordController::class, 'show'])->name('health-records.show');
        Route::post('/health-records/{sheep}', [App\Http\Controllers\HealthRecordController::class, 'store'])->name('health-records.store');
        Route::delete('/health-records/destroy/{healthRecord}', [App\Http\Controllers\HealthRecordController::class, 'destroy'])->name('health-records.destroy');

        // Riwayat Berat
        Route::get('/berat', [App\Http\Controllers\WeightRecordController::class, 'index'])->name('berat.index');
        Route::get('/berat/{sheep}', [App\Http\Controllers\WeightRecordController::class, 'show'])->name('berat.show');
        Route::post('/berat/{sheep}', [App\Http\Controllers\WeightRecordController::class, 'store'])->name('berat.store');

        // Persilangan (Mating)
        Route::resource('mating', App\Http\Controllers\MatingRecordController::class)->parameters([
            'mating' => 'mating'
        ])->except(['show', 'create']);

        // Mating Recommendations
        Route::resource('mating-recommendations', App\Http\Controllers\MatingRecommendationController::class)->only(['index']);
    });

    // Role: Only Owner can access Admin Users (Staff/Owner)
    Route::middleware('role:owner')->group(function () {
        Route::resource('admin-users', AdminUserController::class)->except(['show', 'edit', 'update', 'destroy']);
    });

    //Monitoring IoT
    Route::get('/monitoring', [App\Http\Controllers\MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/{cage}/history', [App\Http\Controllers\MonitoringController::class, 'history'])->name('monitoring.history');
});
