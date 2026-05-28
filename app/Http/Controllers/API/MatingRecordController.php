<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreMatingCheckRequest;
use App\Http\Resources\MatingRecordResource;
use App\Services\MatingRecordService;
use Illuminate\Http\Request;

class MatingRecordController extends BaseController
{
    protected MatingRecordService $matingService;

    public function __construct(MatingRecordService $matingService)
    {
        $this->matingService = $matingService;
    }

    public function getMatingHistory(Request $request)
    {
        $result = $this->matingService->getMatingRecords(
            $request->input('last_id'),
            $request->input('limit', 10),
            $request->input('search')
        );

        return $this->successCursorPaginated(
            MatingRecordResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data riwayat kawin berhasil diambil',
        );
    }

    public function getMatingRecStats()
    {
        $data = $this->matingService->getStats();

        return $this->success($data, 'Statistik riwayat kawin berhasil diambil');
    }

    public function storeCheck(StoreMatingCheckRequest $request)
    {
        $this->matingService->addMatingCheck($request->validated());

        return $this->created(null, 'Pemeriksaan kawin berhasil dicatat dan diperbarui');
    }
}
