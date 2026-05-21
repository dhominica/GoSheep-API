<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\MatingRecordResource;
use App\Models\MatingRecord;
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

        $totalSemua   = MatingRecord::count();
        $totalBunting = MatingRecord::where('result', 'pregnant')->count();
        $totalProses  = MatingRecord::where('result', 'unknown')->count();
        $totalGagal   = MatingRecord::whereIn('result', ['not_pregnant', 'failed'])->count();

        return response()->json([
            'success' => true,
            'message' => 'Data riwayat kawin dan statistik berhasil diambil',
            'stats' => [
                'total_riwayat' => $totalSemua,
                'total_bunting' => $totalBunting,
                'total_proses'  => $totalProses,
                'total_gagal'   => $totalGagal,
            ],
            'data' => MatingRecordResource::collection($result['data']),
            'has_more' => $result['has_more'],
            'next_cursor' => $result['next_cursor']
        ], 200);
    }

    public function storeCheck(Request $request)
    {
        $request->validate([
            'mating_record_id' => 'required|exists:mating_records,id',
            'check_date' => 'required|date',
            'result' => 'required|in:pregnant,failed,unknown'
        ]);

        try {
            $this->matingService->addMatingCheck($request->all());

            return $this->created(null, 'Pemeriksaan kawin berhasil dicatat dan diperbarui');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
    }
}