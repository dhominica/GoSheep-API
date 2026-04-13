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

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Role: Owner & Staff can access Peternak
    Route::middleware('role:owner,staff')->group(function() {
        Route::resource('peternak', PeternakController::class)->except(['show']);
    });

    // Role: Only Owner can access Admin Users (Staff/Owner)
    Route::middleware('role:owner')->group(function() {
        Route::resource('admin-users', AdminUserController::class)->except(['show', 'edit', 'update', 'destroy']);
    });
});
