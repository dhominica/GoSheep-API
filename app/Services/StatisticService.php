<?php

namespace App\Services;

use App\Models\Pregnancy;
use App\Models\Sheep;
use App\Models\MatingRecord;
use App\Enums\PregnancyStatusEnum;
use App\Enums\MatingResultEnum;

class StatisticService
{
    private const UPCOMING_BIRTH_DAYS = 30;

    public function getOverview(): array
    {
        $totalSheep = Sheep::count();

        $pregnantSheep = Pregnancy::query()
            ->where('status', PregnancyStatusEnum::ONGOING)
            ->count();

        $upcomingBirths = Pregnancy::query()
            ->where('status', PregnancyStatusEnum::ONGOING)
            ->whereDate(
                'expected_birth_date',
                '<=',
                now()->addDays(self::UPCOMING_BIRTH_DAYS)
            )
            ->count();

        $successfulMatings = MatingRecord::query()
            ->where('result', MatingResultEnum::PREGNANT)
            ->count();

        $evaluatedMatings = MatingRecord::query()
            ->whereIn('result', [
                MatingResultEnum::PREGNANT,
                MatingResultEnum::FAILED,
            ])
            ->count();

        $pregnancyRate = $evaluatedMatings > 0
            ? round(($successfulMatings / $evaluatedMatings) * 100, 1)
            : 0;

        return [
            'total_sheep' => $totalSheep,
            'pregnant_sheep' => $pregnantSheep,
            'upcoming_births' => $upcomingBirths,
            'pregnancy_rate' => $pregnancyRate,
        ];
    }
}
