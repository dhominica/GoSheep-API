<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SheepHealthOverviewResource;
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
            'Data riwayat kesehatan berhasil diambil'
        );
    }

    public function getStatistics()
    {
        $data = $this->healthRecordsService->getStatistics();

        return $this->success($data, 'Statistik riwayat kesehatan berhasil diambil');
    }
}
