<?php

namespace App\Traits;

trait CalculatesHealthScore
{
    private function calculateHealthScore($sheep): float
    {
        $records = $sheep->healthRecords;

        if ($records->isEmpty()) return 1.0;

        $severityMap = [
            'ringan' => 1,
            'sedang' => 2,
            'berat'  => 3,
            'normal' => 0,
        ];

        $totalEvents   = $records->count();
        $totalSeverity = $records->sum(
            fn($r) => $severityMap[$r->severity] ?? 0
        );

        return round(
            1 - ($totalSeverity / ($totalEvents * 3 + 1e-9)),
            4
        );
    }
}
