<?php

namespace App\Http\Controllers\API;

use App\Models\Sheep;
use App\Services\RecommendationService;
use Illuminate\Http\JsonResponse;

class RecommendationController extends BaseController
{
    private const MIN_AGE_FEMALE = 240; // 8 bulan
    private const MIN_AGE_MALE   = 210; // 7 bulan

    public function __construct(
        private RecommendationService $recommendationService
    ) {}

    public function recommend(int $sheepId): JsonResponse
    {
        $sheep = Sheep::with([
            'breed',
            'sheepFeature',
        ])->findOrFail($sheepId);

        if ($sheep->status !== 'active') {
            return $this->error('Domba tidak aktif.', 422);
        }

        if (!$sheep->sheepFeature?->EBV_Bobot) {
            return $this->error(
                'Data fitur domba belum lengkap. Pastikan data penimbangan sudah diinput.',
                422
            );
        }

        $minAge = $sheep->gender === 'female' ? self::MIN_AGE_FEMALE : self::MIN_AGE_MALE;
        if ($sheep->birth_date->diffInDays(now()) < $minAge) {
            return $this->error(
                'Domba belum cukup umur untuk breeding.',
                422
            );
        }

        if ($sheep->gender === 'female') {
            $ongoingMating = $sheep->matingRecords()
                ->where('result', 'unknown')
                ->exists();

            if ($ongoingMating) {
                return $this->error(
                    'Domba sedang dalam proses perkawinan aktif.',
                    422
                );
            }

            $ongoingPregnancy = $sheep->pregnancies()
                ->where('status', 'ongoing')
                ->exists();

            if ($ongoingPregnancy) {
                return $this->error(
                    'Domba sedang dalam kondisi bunting.',
                    422
                );
            }
        }

        $results = $this->recommendationService->recommend($sheep->id);

        if (empty($results)) {
            return $this->success([
                'selected_sheep'  => $this->formatSheep($sheep),
                'recommendations' => [],
                'total'           => 0,
            ], 'Tidak ada kandidat yang memenuhi syarat.');
        }

        return $this->success([
            'selected_sheep'  => $this->formatSheep($sheep),
            'recommendations' => collect($results)->map(
                fn($r) => $this->formatRecommendation($r)
            ),
            'total'           => count($results),
        ], 'Rekomendasi berhasil dibuat.');
    }

    private function formatSheep(Sheep $sheep): array
    {
        return [
            'id'             => $sheep->id,
            'eartag'         => $sheep->eartag,
            'gender'         => $sheep->gender,
            'breed'          => $sheep->breed?->name,
            'EBV_Bobot'      => $sheep->sheepFeature?->EBV_Bobot,
            'EBV_ADG'        => $sheep->sheepFeature?->EBV_ADG,
            'EBV_Kesehatan'  => $sheep->sheepFeature?->EBV_Kesehatan,
        ];
    }

    private function formatRecommendation(array $r): array
    {
        $sheep = $r['sheep'];

        return [
            'sheep' => [
                'id'     => $sheep->id,
                'eartag' => $sheep->eartag,
                'gender' => $sheep->gender,
                'breed'  => $sheep->breed?->name,
            ],
            'inbreeding_coefficient' => $r['coi'],
            'inbreeding_percent'     => round($r['coi'] * 100, 4),
            'ewe_ebv'                => $r['ewe_ebv'],
            'ram_ebv'                => $r['ram_ebv'],
            'expected_ebv_offspring' => $r['expected_ebv'],
            'scores' => [
                'genetic' => $r['genetic_score'],
                'growth'  => $r['growth_score'],
                'health'  => $r['health_score'],
                'final'   => $r['final_score'],
            ],
        ];
    }
}
