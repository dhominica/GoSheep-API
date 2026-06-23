<?php

namespace App\Observers;

use App\Models\SheepFeature;
use App\Models\WeightRecord;
use App\Services\EBVService;
use App\Traits\CalculatesHealthScore;

class WeightRecordObserver
{
    use CalculatesHealthScore;

    public function __construct(
        private EBVService $ebvService
    ) {}

    public function created(WeightRecord $weightRecord): void
    {
        $sheep = $weightRecord->sheep;

        if (!$sheep) return;

        $birthDate = $sheep->birth_date;

        if (!$birthDate) return;

        $records = $sheep->weightRecords()
            ->orderBy('recorded_at')
            ->get();

        $weightBirth   = $this->getWeightAt($records, $birthDate, 0,   7);
        $weightWeaning = $this->getWeightAt($records, $birthDate, 90,  7);
        $weight180d    = $this->getWeightAt($records, $birthDate, 180, 7);
        $weight365d    = $this->getWeightAt($records, $birthDate, 365, 7);

        $adg0_90 = ($weightBirth && $weightWeaning)
            ? round(($weightWeaning - $weightBirth) / 90, 4)
            : null;

        $adg90_180 = ($weightWeaning && $weight180d)
            ? round(($weight180d - $weightWeaning) / 90, 4)
            : null;

        $healthScore = $this->calculateHealthScore($sheep);

        SheepFeature::updateOrCreate(
            ['sheep_id' => $sheep->id],
            [
                'weight_birth'   => $weightBirth,
                'weight_weaning' => $weightWeaning,
                'weight_180d'    => $weight180d,
                'weight_365d'    => $weight365d,
                'ADG_0_90'       => $adg0_90,
                'ADG_90_180'     => $adg90_180,
                'health_score'   => $healthScore,
                'computed_at'    => now(),
            ]
        );

        $this->ebvService->predictAndSave($sheep->fresh());
    }

    private function getWeightAt(
        $records,
        $birthDate,
        int $targetDay,
        int $tolerance
    ): ?float {
        $filtered = $records->filter(function ($r) use ($birthDate, $targetDay, $tolerance) {
            $daysOld = \Carbon\Carbon::parse($birthDate)
                ->diffInDays(\Carbon\Carbon::parse($r->recorded_at));

            return abs($daysOld - $targetDay) <= $tolerance;
        });

        if ($filtered->isEmpty()) return null;

        return round($filtered->avg('weight'), 2);
    }
}
