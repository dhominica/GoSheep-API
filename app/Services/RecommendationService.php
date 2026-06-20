<?php

namespace App\Services;

use App\Models\Sheep;
use App\Models\MatingRecommendation;
use Illuminate\Support\Facades\Http;

class RecommendationService
{
    private string $apiUrl;

    // Umur minimum siap kawin (dalam hari)
    private const MIN_AGE_FEMALE = 240; // 8 bulan
    private const MIN_AGE_MALE   = 210; // 7 bulan

    private array $pairwiseMatrix = [
        'EBV_Bobot'     => [1,     2,     3],
        'EBV_ADG'       => [1/2,   1,     2],
        'EBV_Kesehatan' => [1/3,   1/2,   1],
    ];

    private array $criteria = [
        'EBV_Bobot',
        'EBV_ADG',
        'EBV_Kesehatan',
    ];

    public function __construct()
    {
        $this->apiUrl = config('services.gosheep_ai.url');
    }

    public function recommend(int $sheepId): array
    {
        $selected = Sheep::with('sheepFeature')->findOrFail($sheepId);

        $isEweSelected   = $selected->gender === 'female';
        $candidateGender = $isEweSelected ? 'male' : 'female';
        $minAge          = $candidateGender === 'female'
                            ? self::MIN_AGE_FEMALE
                            : self::MIN_AGE_MALE;

        $candidateQuery = Sheep::with('sheepFeature')
            ->where('gender', $candidateGender)
            ->where('status', 'active')
            ->where('id', '!=', $sheepId)
            ->where('birth_date', '<=', now()->subDays($minAge));

        if ($candidateGender === 'female') {
            $candidateQuery
                ->whereDoesntHave('pregnancies', function ($q) {
                    $q->where('status', 'ongoing');
                })
                ->whereDoesntHave('matingRecords', function ($q) {
                    $q->where('result', 'unknown');
                });
        }

        $candidateSheep = $candidateQuery->get();

        if ($candidateSheep->isEmpty()) return [];

        $response = Http::timeout(30)->post(
            "{$this->apiUrl}/wright/filter",
            [
                'selected_id'     => $sheepId,
                'candidate_ids'   => $candidateSheep->pluck('id')->toArray(),
                'is_ewe_selected' => $isEweSelected,
            ]
        );

        if (!$response->successful()) return [];

        $safeCandidateIds = collect($response->json('safe_candidates'))
            ->pluck('sheep_id')
            ->toArray();

        $coiMap = collect($response->json('safe_candidates'))
            ->keyBy('sheep_id');

        if (empty($safeCandidateIds)) return [];

        $safeCandidates = $candidateSheep
            ->whereIn('id', $safeCandidateIds)
            ->map(fn($sheep) => [
                'sheep' => $sheep,
                'coi'   => $coiMap[$sheep->id]['coi'] ?? 0,
            ])
            ->values()
            ->toArray();

        $withExpectedEBV = $this->calculateExpectedOffspring(
            $selected,
            $safeCandidates,
            $isEweSelected
        );

        if (empty($withExpectedEBV)) return [];

        $weights = $this->calculateAHPWeights();
        $ranked  = $this->mooraRanking($withExpectedEBV, $weights);

        $this->saveRecommendations(
            $selected,
            $ranked,
            $weights,
            $isEweSelected
        );

        return $ranked;
    }

    private function calculateAHPWeights(): array
    {
        $matrix  = array_values($this->pairwiseMatrix);
        $n       = count($this->criteria);
        $colSums = array_fill(0, $n, 0.0);

        foreach ($matrix as $row) {
            foreach ($row as $j => $val) {
                $colSums[$j] += $val;
            }
        }

        $normalized = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $val) {
                $normalized[$i][$j] = $val / $colSums[$j];
            }
        }

        $weights = [];
        foreach ($this->criteria as $i => $criterion) {
            $weights[$criterion] = array_sum($normalized[$i]) / $n;
        }

        return $weights;
    }

    private function calculateExpectedOffspring(
        Sheep $selectedSheep,
        array $candidates,
        bool  $isEweSelected
    ): array {
        $selectedFeature = $selectedSheep->sheepFeature;

        if (!$selectedFeature) return [];

        $results = [];

        foreach ($candidates as $candidate) {
            $candidateFeature = $candidate['sheep']->sheepFeature;

            if (!$candidateFeature) continue;

            if ($isEweSelected) {
                $eweFeature = $selectedFeature;
                $ramFeature = $candidateFeature;
            } else {
                $eweFeature = $candidateFeature;
                $ramFeature = $selectedFeature;
            }

            if (!$eweFeature->EBV_Bobot && !$ramFeature->EBV_Bobot) continue;

            $expectedEBV = [];
            foreach ($this->criteria as $criterion) {
                $eweEBV = (float) ($eweFeature->$criterion ?? 0);
                $ramEBV = (float) ($ramFeature->$criterion ?? 0);

                $expectedEBV[$criterion] = round(
                    ($eweEBV + $ramEBV) / 2, 4
                );
            }

            $results[] = [
                'sheep'        => $candidate['sheep'],
                'coi'          => $candidate['coi'],
                'ewe_ebv'      => [
                    'EBV_Bobot'     => (float) $eweFeature->EBV_Bobot,
                    'EBV_ADG'       => (float) $eweFeature->EBV_ADG,
                    'EBV_Kesehatan' => (float) $eweFeature->EBV_Kesehatan,
                ],
                'ram_ebv'      => [
                    'EBV_Bobot'     => (float) $ramFeature->EBV_Bobot,
                    'EBV_ADG'       => (float) $ramFeature->EBV_ADG,
                    'EBV_Kesehatan' => (float) $ramFeature->EBV_Kesehatan,
                ],
                'expected_ebv' => $expectedEBV,
            ];
        }

        return $results;
    }

    private function mooraRanking(array $candidates, array $weights): array
    {
        if (empty($candidates)) return [];

        $values = [];
        foreach ($this->criteria as $criterion) {
            $values[$criterion] = array_column(
                array_column($candidates, 'expected_ebv'),
                $criterion
            );
        }

        $normalized = [];
        foreach ($this->criteria as $criterion) {
            $sumOfSquares = array_sum(
                array_map(fn($v) => $v ** 2, $values[$criterion])
            );
            $denominator = sqrt($sumOfSquares) ?: 1e-9;

            $normalized[$criterion] = array_map(
                fn($v) => $v / $denominator,
                $values[$criterion]
            );
        }

        foreach ($candidates as $i => $candidate) {
            $score = 0.0;
            foreach ($this->criteria as $criterion) {
                $score += $weights[$criterion] * $normalized[$criterion][$i];
            }

            $candidates[$i]['final_score']   = round($score, 6);
            $candidates[$i]['genetic_score'] = round($normalized['EBV_Bobot'][$i]     * $weights['EBV_Bobot'], 6);
            $candidates[$i]['growth_score']  = round($normalized['EBV_ADG'][$i]       * $weights['EBV_ADG'], 6);
            $candidates[$i]['health_score']  = round($normalized['EBV_Kesehatan'][$i] * $weights['EBV_Kesehatan'], 6);
        }

        usort($candidates, fn($a, $b) => $b['final_score'] <=> $a['final_score']);

        return $candidates;
    }

    private function saveRecommendations(
        Sheep $selected,
        array $ranked,
        array $weights,
        bool  $isEweSelected
    ): void {
        foreach ($ranked as $candidate) {
            [$eweId, $ramId] = $isEweSelected
                ? [$selected->id, $candidate['sheep']->id]
                : [$candidate['sheep']->id, $selected->id];

            MatingRecommendation::where('ewe_id', $eweId)
                ->where('ram_id', $ramId)
                ->update(['is_valid' => false]);

            MatingRecommendation::create([
                'ewe_id'                 => $eweId,
                'ram_id'                 => $ramId,
                'inbreeding_coefficient' => $candidate['coi'],
                'ewe_ebv'                => $candidate['ewe_ebv'],
                'ram_ebv'                => $candidate['ram_ebv'],
                'expected_ebv_offspring' => $candidate['expected_ebv'],
                'ahp_weights'            => $weights,
                'genetic_score'          => $candidate['genetic_score'],
                'growth_score'           => $candidate['growth_score'],
                'health_score'           => $candidate['health_score'],
                'final_score'            => $candidate['final_score'],
                'is_valid'               => true,
            ]);
        }
    }
}
