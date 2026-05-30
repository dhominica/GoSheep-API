<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OverviewResource;
use App\Services\StatisticService;

class StatisticController extends BaseController
{
    protected StatisticService $statisticService;

    public function __construct(StatisticService $sheepService)
    {
        $this->statisticService = $sheepService;
    }

    public function overview()
    {
        $data = $this->statisticService->getOverview();

        return $this->success(new OverviewResource($data), 'Overview statisik berhasil diambil');
    }
}
