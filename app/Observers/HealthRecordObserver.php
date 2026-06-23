<?php

namespace App\Observers;

use App\Models\HealthRecord;
use App\Models\SheepFeature;
use App\Services\EBVService;
use App\Traits\CalculatesHealthScore;

class HealthRecordObserver
{
    use CalculatesHealthScore;

    public function __construct(
        private EBVService $ebvService
    ) {}

    public function created(HealthRecord $healthRecord): void
    {
        $sheep = $healthRecord->sheep;

        if (!$sheep) return;

        $healthScore = $this->calculateHealthScore($sheep);

        $updated = SheepFeature::where('sheep_id', $sheep->id)
            ->update([
                'health_score' => $healthScore,
                'computed_at'  => now(),
            ]);

        if (!$updated) return;

        $this->ebvService->predictAndSave($sheep->fresh());
    }
}
