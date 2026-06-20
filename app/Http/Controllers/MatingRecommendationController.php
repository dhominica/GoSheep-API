<?php

namespace App\Http\Controllers;

use App\Models\MatingRecommendation;
use Illuminate\Http\Request;

class MatingRecommendationController extends Controller
{
    /**
     * Display a listing of mating recommendations.
     */
    public function index()
    {
        $sheeps = \App\Models\Sheep::with(['breed', 'pregnancies', 'matingRecords', 'sheepFeature'])
            ->where('status', 'active')
            ->orderBy('eartag')
            ->get();

        $sheeps->transform(function ($sheep) {
            $sheep->age_days = $sheep->birth_date->diffInDays(now());

            // Age limit based on gender: Female = 240 days, Male = 210 days
            $minAge = $sheep->gender === 'female' ? 240 : 210;

            if ($sheep->age_days < $minAge) {
                $sheep->breeding_status = 'Belum Cukup Umur';
                $sheep->is_eligible = false;
            } elseif (!$sheep->sheepFeature?->EBV_Bobot) {
                $sheep->breeding_status = 'Data Belum Lengkap';
                $sheep->is_eligible = false;
            } elseif ($sheep->gender === 'female' && $sheep->pregnancies->where('status', 'ongoing')->isNotEmpty()) {
                $sheep->breeding_status = 'Sedang Bunting';
                $sheep->is_eligible = false;
            } elseif ($sheep->gender === 'female' && $sheep->matingRecords->where('result', 'unknown')->isNotEmpty()) {
                $sheep->breeding_status = 'Proses Kawin';
                $sheep->is_eligible = false;
            } else {
                $sheep->breeding_status = 'Siap Kawin';
                $sheep->is_eligible = true;
            }

            return $sheep;
        });

        $rams = $sheeps->where('gender', 'male')->values();
        $ewes = $sheeps->where('gender', 'female')->values();

        return view('mating-recommendations.index', compact('rams', 'ewes'));
    }

    public function getRecommendations(int $sheepId)
    {
        $sheep = \App\Models\Sheep::with(['breed', 'sheepFeature'])->findOrFail($sheepId);

        $recommendationService = resolve(\App\Services\RecommendationService::class);
        $results = $recommendationService->recommend($sheep->id);

        if (empty($results)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kandidat yang memenuhi syarat.',
                'data' => [
                    'selected_sheep' => [
                        'id' => $sheep->id,
                        'eartag' => $sheep->eartag,
                        'gender' => $sheep->gender,
                        'breed' => $sheep->breed?->name,
                        'EBV_Bobot' => $sheep->sheepFeature?->EBV_Bobot,
                        'EBV_ADG' => $sheep->sheepFeature?->EBV_ADG,
                        'EBV_Kesehatan' => $sheep->sheepFeature?->EBV_Kesehatan,
                    ],
                    'recommendations' => [],
                    'total' => 0
                ]
            ]);
        }

        // Retrieve the saved recommendations from database to get their IDs
        $dbRecs = MatingRecommendation::where(
            $sheep->gender === 'female' ? 'ewe_id' : 'ram_id',
            $sheep->id
        )->where('is_valid', true)->get()->keyBy(function ($item) use ($sheep) {
            return $sheep->gender === 'female' ? $item->ram_id : $item->ewe_id;
        });

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil dibuat.',
            'data' => [
                'selected_sheep' => [
                    'id' => $sheep->id,
                    'eartag' => $sheep->eartag,
                    'gender' => $sheep->gender,
                    'breed' => $sheep->breed?->name,
                    'EBV_Bobot' => $sheep->sheepFeature?->EBV_Bobot,
                    'EBV_ADG' => $sheep->sheepFeature?->EBV_ADG,
                    'EBV_Kesehatan' => $sheep->sheepFeature?->EBV_Kesehatan,
                ],
                'recommendations' => collect($results)->map(function ($r) use ($dbRecs, $sheep) {
                    $partnerId = $r['sheep']->id;
                    $dbRec = $dbRecs->get($partnerId);
                    return [
                        'id' => $dbRec?->id,
                        'sheep' => [
                            'id' => $r['sheep']->id,
                            'eartag' => $r['sheep']->eartag,
                            'gender' => $r['sheep']->gender,
                            'breed' => $r['sheep']->breed?->name,
                        ],
                        'inbreeding_coefficient' => $r['coi'],
                        'inbreeding_percent' => round($r['coi'] * 100, 4),
                        'ewe_ebv' => $r['ewe_ebv'],
                        'ram_ebv' => $r['ram_ebv'],
                        'expected_ebv_offspring' => $r['expected_ebv'],
                        'scores' => [
                            'genetic' => $r['genetic_score'],
                            'growth' => $r['growth_score'],
                            'health' => $r['health_score'],
                            'final' => $r['final_score'],
                        ],
                    ];
                })->toArray(),
                'total' => count($results)
            ]
        ]);
    }
}
