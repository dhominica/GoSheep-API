<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWeightRecordRequest;
use App\Http\Resources\SheepWeightResource;
use App\Http\Resources\WeightRecordResource;
use App\Services\WeightRecordService;
use Illuminate\Http\Request;

class WeightRecordController extends BaseController
{
    protected WeightRecordService $weightRecordService;

    public function __construct(WeightRecordService $weightRecordService)
    {
        $this->weightRecordService = $weightRecordService;
    }

    public function getSheepWeight(Request $request)
    {
        $result = $this->weightRecordService->getSheepWeight(
            $request->input('last_id'),
            $request->input('limit', 10),
            $request->input('search')
        );

        return $this->successCursorPaginated(
            SheepWeightResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data berat badan berhasil diambil'
        );
    }

    public function getWeightRecord(Request $request, int $sheepId)
    {
        $result = $this->weightRecordService->getWeightRecord(
            $sheepId,
            $request->input('last_id'),
            $request->input('limit', 10),
        );

        return $this->successCursorPaginated(
            new WeightRecordResource($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Riwayat berat badan domba berhasil diambil',
        );
    }

    public function store(StoreWeightRecordRequest $request)
    {
        $record = $this->weightRecordService->store($request->validated());

        return $this->created(
            new WeightRecordResource($record),
            'Rekam berat badan berhasil ditambahkan',
        );
    }

    public function getMonthlyWeightStatistics(int $sheepId, Request $request)
    {
        $year = (int) $request->input('year');

        $statistics = $this->weightRecordService->getMonthlyWeightStatistics($sheepId, $year ?: null);

        return $this->success(
            $statistics,
            'Statistik berat badan bulanan berhasil diambil',
        );
    }

    public function getAllSheepMonthlyWeightStatistics(Request $request)
    {
        $year = (int) $request->input('year');

        $statistics = $this->weightRecordService->getAllSheepMonthlyStatistics($year ?: null);

        return $this->success(
            $statistics,
            'Statistik berat badan bulanan untuk semua domba berhasil diambil',
        );
    }
}
