<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreSheepRequest;
use App\Http\Resources\SheepDetailResource;
use App\Http\Resources\SheepResource;
use App\Services\SheepService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SheepController extends BaseController
{
    protected SheepService $sheepService;

    public function __construct(SheepService $sheepService)
    {
        $this->sheepService = $sheepService;
    }

    public function index(Request $request)
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

     public function store(StoreSheepRequest $request)
     {
        try {
            $sheep = $this->sheepService->createSheep(
                $request->validated()
            );

            return $this->created(
                new SheepResource($sheep),
                'Domba berhasil ditambahkan'
            );

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 400);
        }
     }

    public function show($id)
    {
        $sheep = $this->sheepService->getSheepDetails($id);

        return $this->success(new SheepDetailResource($sheep), 'Detail domba berhasil diambil');
    }

    public function healthStatusStats(SheepService $service)
    {
        $data = $service->healthStatusStats();

        return $this->success($data, 'Statistik kesehatan domba berhasil diambil');
    }

    public function deleteSheep($id)
    {
        $this->sheepService->deleteSheep($id);

        return $this->deleted('Domba berhasil dihapus');
    }
}
