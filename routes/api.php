<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\SheepController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/sheep', [SheepController::class, 'getSheep']);
Route::delete('/sheep/{id}', [SheepController::class, 'deleteSheep']);
