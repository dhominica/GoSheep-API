<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SheepResource;
use App\Services\SheepService;
use Illuminate\Http\Request;

class SheepController extends BaseController
{
    protected $sheepService;

    public function __construct(SheepService $sheepService)
    {
        $this->sheepService = $sheepService;
    }

    public function getSheep(Request $request)
    {
        $lastId = $request->input('last_id');
        $limit = $request->input('limit', 10);

        $result = $this->sheepService->getSheep($lastId, $limit);

        return $this->successCursorPaginated(
            SheepResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data domba berhasil diambil'
        );
    }

    public function deleteSheep($id)
    {
        $this->sheepService->deleteSheep($id);

        return $this->deleted('Domba berhasil dihapus');
    }
}
