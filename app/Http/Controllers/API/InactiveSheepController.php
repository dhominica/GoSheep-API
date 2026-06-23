<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\InactiveSheepResource;
use App\Services\InactiveSheepService;
use App\Models\Sheep;
use Illuminate\Http\Request;

class InactiveSheepController extends BaseController
{
    protected InactiveSheepService $inactiveSheepService;

    public function __construct(InactiveSheepService $inactiveSheepService)
    {
        $this->inactiveSheepService = $inactiveSheepService;
    }

    public function index(Request $request)
    {
        $result = $this->inactiveSheepService->getInactiveSheep(
            $request->input('last_id'),
            $request->input('limit', 10),
            $request->input('search')
        );

        return $this->successCursorPaginated(
            InactiveSheepResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data ternak nonaktif berhasil diambil'
        );
    }

    public function stats()
    {
        $soldCount = Sheep::where('status', 'sold')->count();
        $deadCount = Sheep::where('status', 'dead')->count();
        $inactiveCount = Sheep::where('status', 'inactive')->count();

        return $this->success([
            'sold_total' => $soldCount,
            'dead_total' => $deadCount,
            'inactive_total' => $inactiveCount,
        ], 'Statistik ternak nonaktif berhasil diambil');
    }
}
