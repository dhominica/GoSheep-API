<?php

namespace App\Services;

use App\Models\Sheep;
use App\Models\SheepFeature;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EBVService
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.gosheep_ai.url');
    }

    public function predictAndSave(Sheep $sheep): void
    {
        $feature = $sheep->sheepFeature;

        // Belum ada fitur -> skip
        if (!$feature || !$feature->weight_birth || !$feature->weight_weaning || !$feature->ADG_0_90) {
            return;
        }

        $payload = [
            'gender_enc'     => $sheep->gender === 'male' ? 1 : 0,
            'breed_id'       => $sheep->breed_id,
            'weight_birth'   => (float) $feature->weight_birth,
            'weight_weaning' => (float) $feature->weight_weaning,
            'ADG_0_90'       => (float) $feature->ADG_0_90,
            'health_score'   => (float) ($feature->health_score ?? 1.0),
        ];

        $response = Http::timeout(10)
            ->post("{$this->apiUrl}/predict/ebv", $payload);

        if (!$response->successful()) {
            Log::error('EBV prediction failed', [
                'sheep_id' => $sheep->id,
                'status'   => $response->status(),
                'body'     => $response->body(),
            ]);
            return;
        }

        $result = $response->json();

        SheepFeature::updateOrCreate(
            ['sheep_id' => $sheep->id],
            [
                'EBV_Bobot'     => $result['EBV_Bobot'],
                'EBV_ADG'       => $result['EBV_ADG'],
                'EBV_Kesehatan' => $result['EBV_Kesehatan'],
                'computed_at'   => now(),
            ]
        );
    }
}
