<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreHealthRecordRequest;
use App\Http\Requests\UpdateHealthRecordRequest;
use App\Http\Resources\HealthRecordResource;
use App\Http\Resources\HealthResource;
use App\Http\Resources\SheepHealthOverviewResource;
use App\Http\Resources\UpdateHealthRecordResource;
use App\Models\HealthRecord;
use App\Services\HealthRecordsService;
use Illuminate\Http\Request;

class HealthRecordsController extends BaseController
{
    protected HealthRecordsService $healthRecordsService;
    public function __construct(HealthRecordsService $healthRecordsService)
    {
        $this->healthRecordsService = $healthRecordsService;
    }

    public function getHealthRecord(Request $request)
    {
        $result = $this->healthRecordsService->getHealthRecords(
            $request->input('last_id'),
            $request->input('limit', 10),
            $request->input('search')
        );

        return $this->successCursorPaginated(
            SheepHealthOverviewResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data kesehatan berhasil diambil'
        );
    }

    public function store(StoreHealthRecordRequest $request)
    {
        $record = $this->healthRecordsService->store($request->validated());

        return $this->created(
            new HealthResource($record),
            'Rekam medis berhasil ditambahkan',
        );
    }

    public function update(UpdateHealthRecordRequest $request, HealthRecord $healthRecord)
    {
        $record = $this->healthRecordsService->update($healthRecord, $request->validated());

        return $this->updated(
            new UpdateHealthRecordResource($record),
            'Rekam medis berhasil diperbarui',
        );
    }

    public function getHealthRecordDetail(Request $request, int $sheepId)
    {
        $result = $this->healthRecordsService->getHealthRecordDetail(
            $sheepId,
            $request->input('last_id'),
            $request->input('limit', 10),
        );

        return $this->successCursorPaginated(
            new HealthRecordResource($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Riwayat kesehatan domba berhasil diambil',
        );
    }

    public function getStatistics()
    {
        $data = $this->healthRecordsService->getStatistics();

        return $this->success($data, 'Statistik riwayat kesehatan berhasil diambil');
    }
}

