<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SheepDetailResource;
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

    public function store (Request $request)
    {
        $validated = $request->validate([
            'eartag'         => 'required|unique:sheep,eartag',
            'gender'         => 'required|in:male,female',
            'birth_date'     => 'required|date',
            'eartag_color'   => 'required|string',
            'initial_weight' => 'required|numeric',
            'breed_id'       => 'nullable|exists:breeds,id',
            'cage_id'        => 'nullable|exists:cages,id',
            'sire_id'        => 'nullable|exists:sheep,id',
            'dam_id'         => 'nullable|exists:sheep,id',
            'health_status'  => 'nullable|string',
        ]);

        $sheep = $this->sheepService->createSheep($validated);
        
        return $this->created(new SheepDetailResource($sheep), 'Berhasil!');
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
