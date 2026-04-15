<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CageResource;
use App\Services\CageService;
use Illuminate\Http\JsonResponse;

 class CageController extends BaseController
{
    protected $cageService;

    public function __construct(CageService $cageService)
    {
        $this->cageService = $cageService;
    }

    public function index(): JsonResponse
    {
        $cages = $this->cageService->getAllCagesWithSheep();

        $data = CageResource::collection($cages);

        return $this->success($data, 'Daftar kandang berhasil diambil');
    }
}
