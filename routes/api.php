<?php

use App\Http\Controllers\API\ActivityFeedController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CageController;
use App\Http\Controllers\API\HealthRecordsController;
use App\Http\Controllers\API\InactiveSheepController;
use App\Http\Controllers\API\MatingRecordController;
use App\Http\Controllers\API\PregnantSheepController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RecommendationController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\SheepController;
use App\Http\Controllers\API\SheepFormController;
use App\Http\Controllers\API\StatisticController;
use App\Http\Controllers\API\WeightRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/request-password-reset', [AuthController::class, 'requestPasswordReset']);

Route::middleware(['auth:sanctum', 'role:peternak'])->group(function () {
    Route::prefix('sheep')->group(function () {
        Route::get('/health-stats', [SheepController::class, 'healthStatusStats']);
        Route::get('/', [SheepController::class, 'index']);
        Route::get('/inactive', [InactiveSheepController::class, 'index']);
        Route::get('/inactive/stats', [InactiveSheepController::class, 'stats']);
        Route::post('/', [SheepController::class, 'store']);
        Route::get('/{id}', [SheepController::class, 'show']);
        Route::delete('/{id}', [SheepController::class, 'deleteSheep']);
        Route::get('scan/{earTag}', [SheepController::class, 'scan']);
    });
    
    Route::prefix('recommendations')->group(function () {
        Route::get('/sheep', [RecommendationController::class, 'sheepList']);
        Route::get('/{sheepId}', [RecommendationController::class, 'recommend']);
    });

    Route::prefix('reports')->group(function () {
        Route::get('/farm', [ReportController::class, 'farm']);
    });

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/cages', [CageController::class, 'index']);

    Route::prefix('sheep-form')->group(function () {
        Route::get('/breeds', [SheepFormController::class, 'breeds']);
        Route::get('/cages', [SheepFormController::class, 'cages']);
        Route::get('/sires', [SheepFormController::class, 'sires']);
        Route::get('/dams', [SheepFormController::class, 'dams']);
    });

    Route::prefix('mating-records')->group(function () {
        Route::get('/', [MatingRecordController::class, 'getMatingHistory']);
        Route::post('/', [MatingRecordController::class, 'store']);
        Route::get('/stats', [MatingRecordController::class, 'getMatingRecStats']);
        Route::post('/check/{matingId}', [MatingRecordController::class, 'storeCheck']);
        Route::put('/check/{matingCheck}', [MatingRecordController::class, 'updateCheck'])->whereNumber('matingCheck');
        Route::get('/check/{matingId}', [MatingRecordController::class, 'getMatingCheck']);
        Route::get('/partners/{sheepId}', [MatingRecordController::class, 'getPartners']);
        Route::get('/{id}', [MatingRecordController::class, 'show'])->whereNumber('id');
    });

    Route::prefix('health-records')->group(function () {
        Route::get('/', [HealthRecordsController::class, 'getHealthRecord']);
        Route::get('/statistics', [HealthRecordsController::class, 'getStatistics']);
        Route::get('/{sheep}', [HealthRecordsController::class, 'getHealthRecordDetail'])->whereNumber('sheep');
        Route::post('/', [HealthRecordsController::class, 'store']);
        Route::put('/{healthRecord}', [HealthRecordsController::class, 'update'])->whereNumber('healthRecord');
    });

    Route::prefix('sheep-weight')->group(function () {
        Route::get('/', [WeightRecordController::class, 'getSheepWeight']);
        Route::get('/{sheep}/records', [WeightRecordController::class, 'getWeightRecord']);
        Route::post('/', [WeightRecordController::class, 'store']);
        Route::put('/{weightRecord}', [WeightRecordController::class, 'update'])->whereNumber('weightRecord');
        Route::get('/statistics', [WeightRecordController::class, 'getAllSheepMonthlyWeightStatistics']);
        Route::get('/{sheep}/statistics', [WeightRecordController::class, 'getMonthlyWeightStatistics']);
    });

    Route::get('/activity-feed', [ActivityFeedController::class, 'index']);

    Route::prefix('statistics')->group(function () {
        Route::get('/overview', [StatisticController::class, 'overview']);
    });

    Route::prefix('sheep-pregnancies')->group(function () {
        Route::get('/', [PregnantSheepController::class, 'getPregnancies']);
        Route::get('/mating-record/{matingRecordId}', [PregnantSheepController::class, 'getByMatingRecord'])->whereNumber('matingRecordId');
        Route::get('/summary', [PregnantSheepController::class, 'summary']);
        Route::put('/{pregnancy}', [PregnantSheepController::class, 'update'])->whereNumber('pregnancy');
    });
});
