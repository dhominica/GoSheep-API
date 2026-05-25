<?php

namespace App\Services;

use App\Events\NewEnvironmentData;
use App\Models\CageEnvironmentLog;

class IoTService
{
    public function processEnvironmentData(
        int $cageId,
        array $data
    ): CageEnvironmentLog {
        $log = CageEnvironmentLog::create([
            'cage_id' => $cageId,
            'temperature' => $data['suhu'],
            'humidity' => $data['kelembapan'],
            'recorded_at' => now(),
        ]);

        NewEnvironmentData::dispatch(
            $cageId,
            (float) $log->temperature,
            (float) $log->humidity,
            $log->recorded_at->toIso8601String()
        );

        return $log;
    }
}
