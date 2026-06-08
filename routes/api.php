<?php

use App\Http\Controllers\API\ActivityFeedController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CageController;
use App\Http\Controllers\API\MatingRecordController;
use App\Http\Controllers\API\SheepController;
use App\Http\Controllers\API\SheepFormController;
use App\Http\Controllers\API\StatisticController;
use App\Http\Controllers\API\HealthRecordsController;
use App\Http\Controllers\API\WeightRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('sheep')->group(function () {
        Route::get('/health-stats', [SheepController::class, 'healthStatusStats']);
        Route::get('/', [SheepController::class, 'index']);
        Route::post('/', [SheepController::class, 'store']);
        Route::get('/{id}', [SheepController::class, 'show']);
        Route::delete('/{id}', [SheepController::class, 'deleteSheep']);
        Route::get('scan/{earTag}', [SheepController::class, 'scan']);
    });

    Route::get('/cages', [CageController::class, 'index']);

    Route::prefix('sheep-form')->group(function () {
        Route::get('/breeds', [SheepFormController::class, 'breeds']);
        Route::get('/cages', [SheepFormController::class, 'cages']);
        Route::get('/sires', [SheepFormController::class, 'sires']);
        Route::get('/dams', [SheepFormController::class, 'dams']);
    });

    Route::prefix('mating-records')->group(function () {
        Route::get('/', [MatingRecordController::class, 'getMatingHistory']);
        Route::get('/stats', [MatingRecordController::class, 'getMatingRecStats']);
        Route::post('/check/{matingId}', [MatingRecordController::class, 'storeCheck']);
        Route::get('/check/{matingId}', [MatingRecordController::class, 'getMatingCheck']);
    });

    Route::prefix('health-records')->group(function () {
        Route::get('/', [HealthRecordsController::class, 'getHealthRecord']);
        Route::get('/statistics', [HealthRecordsController::class, 'getStatistics']);
        Route::get('/{sheep}', [HealthRecordsController::class, 'getHealthRecordDetail'])->whereNumber('sheep');
        Route::post('/', [HealthRecordsController::class, 'store']);
    });

    Route::prefix('sheep-weight')->group(function () {
        Route::get('/', [WeightRecordController::class, 'getSheepWeight']);
        Route::get('/{sheep}/records', [WeightRecordController::class, 'getWeightRecord']);
        Route::post('/', [WeightRecordController::class, 'store']);
        Route::get('/statistics', [WeightRecordController::class, 'getAllSheepMonthlyWeightStatistics']);
        Route::get('/{sheep}/statistics', [WeightRecordController::class, 'getMonthlyWeightStatistics']);
    });

    Route::get('/activity-feed', [ActivityFeedController::class, 'index']);

    Route::prefix('statistics')->group(function () {
        Route::get('/overview', [StatisticController::class, 'overview']);
    });
});
