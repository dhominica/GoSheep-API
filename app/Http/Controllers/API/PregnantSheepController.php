<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PregnanciesResource;
use App\Services\PregnantSheepService;
use Illuminate\Http\Request;

class PregnantSheepController extends BaseController
{
    protected PregnantSheepService $pregnantSheepService;

    public function __construct(PregnantSheepService $pregnantSheepService)
    {
        $this->pregnantSheepService = $pregnantSheepService;
    }

    public function summary()
    {
        $summary = $this->pregnantSheepService->getPregnancySummary();

        return $this->success($summary);
    }

    public function getPregnancies(Request $request)
    {
        $result = $this->pregnantSheepService->getPregnancies(
            $request->input('last_id'),
            $request->input('limit', 10),
            $request->input('search')
        );

        return $this->successCursorPaginated(
            PregnanciesResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor']
        );
    }
}
