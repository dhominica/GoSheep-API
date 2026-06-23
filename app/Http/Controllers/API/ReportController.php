<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\FarmReportResource;
use App\Services\ReportService;

class ReportController extends BaseController
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function farm()
    {
        $report = $this->reportService->getFarmReport();

        return $this->success(
            new FarmReportResource($report),
            'Laporan peternakan berhasil diambil'
        );
    }
}
