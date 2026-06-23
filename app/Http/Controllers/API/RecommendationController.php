<?php

namespace App\Http\Controllers\API;

use App\Models\Sheep;
use App\Services\RecommendationService;
use App\Http\Resources\SheepBreedingResource;
use App\Http\Resources\RecommendationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecommendationController extends BaseController
{
    public function __construct(
        private RecommendationService $recommendationService
    ) {}

    /**
     * Ambil list domba + status kelayakan kawin.
     * Dipakai Flutter untuk render list + lock card.
     *
     * GET /api/recommendations/sheep?gender=female
     */
    public function sheepList(Request $request): JsonResponse
    {
        $gender = $request->query('gender'); // 'male' / 'female' / null

        $sheep = $this->recommendationService->getSheepList($gender);

        return $this->success(
            SheepBreedingResource::collection($sheep),
            'Daftar domba berhasil dimuat.'
        );
    }

    /**
     * Generate rekomendasi pasangan untuk 1 domba.
     *
     * GET /api/recommendations/{sheepId}
     */
    public function recommend(int $sheepId): JsonResponse
    {
        $sheep = Sheep::with([
            'breed',
            'sheepFeature',
            'pregnancies',
            'matingRecords',
        ])->findOrFail($sheepId);

        $validation = $this->recommendationService->validateEligibility($sheep);
        if ($validation !== null) {
            return $this->error($validation, 422);
        }

        $sheep = $this->recommendationService->addBreedingAttributes($sheep);
        $results = $this->recommendationService->recommend($sheep->id);

        if (empty($results)) {
            return $this->success([
                'selected_sheep'  => new SheepBreedingResource($sheep),
                'recommendations' => [],
                'total'           => 0,
            ], 'Tidak ada kandidat yang memenuhi syarat.');
        }

        return $this->success([
            'selected_sheep'  => new SheepBreedingResource($sheep),
            'recommendations' => RecommendationResource::collection(
                collect($results)
            ),
            'total'           => count($results),
        ], 'Rekomendasi berhasil dibuat.');
    }
}
