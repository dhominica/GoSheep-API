<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SheepController;
use App\Http\Controllers\API\CageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/sheep/health-stats', [SheepController::class, 'healthStatusStats']);
Route::get('/sheep', [SheepController::class, 'index']);
Route::post('/sheep', [SheepController::class, 'store']);
Route::get('/sheep/{id}', [SheepController::class, 'show']);
Route::delete('/sheep/{id}', [SheepController::class, 'deleteSheep']);
Route::get('/cages', [CageController::class, 'index']);
