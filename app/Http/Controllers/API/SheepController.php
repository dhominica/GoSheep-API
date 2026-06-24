<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreSheepRequest;
use App\Http\Requests\UpdateSheepRequest;
use App\Http\Resources\SheepDetailResource;
use App\Http\Resources\SheepResource;
use App\Services\SheepService;
use Illuminate\Http\Request;

class SheepController extends BaseController
{
    protected SheepService $sheepService;

    public function __construct(SheepService $sheepService)
    {
        $this->sheepService = $sheepService;
    }

    public function index(Request $request)
    {
        $result = $this->sheepService->getSheep(
            $request->input('last_id'),
            $request->input('limit', 10),
            $request->input('search')
        );

        return $this->successCursorPaginated(
            SheepResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Data domba berhasil diambil'
        );
    }

     public function store(StoreSheepRequest $request)
     {
            $sheep = $this->sheepService->createSheep(
                $request->validated()
            );

            return $this->created(
                new SheepResource($sheep),
                'Domba berhasil ditambahkan'
            );
     }

    public function show(int $id)
    {
        $sheep = $this->sheepService->getSheepDetails($id);

        return $this->success(new SheepDetailResource($sheep), 'Detail domba berhasil diambil');
    }

    public function healthStatusStats()
    {
        $data = $this->sheepService->healthStatusStats();

        return $this->success($data, 'Statistik kesehatan domba berhasil diambil');
    }

    public function deleteSheep(int $id)
    {
        $this->sheepService->deleteSheep($id);

        return $this->deleted('Domba berhasil dihapus');
    }

    public function scan(string $earTag)
    {
        $sheep = $this->sheepService->scanSheep($earTag);

        return $this->success(
            new SheepDetailResource($sheep),
            'Domba berhasil ditemukan'
        );
    }

    public function update(UpdateSheepRequest $request, int $id)
    {
        $sheep = $this->sheepService->updateSheep(
            $id,
            $request->validated()
        );

        return $this->updated(
            new SheepDetailResource($sheep),
            'Data domba berhasil diperbarui'
        );
    }
}
