<?php

namespace App\Services;

use App\Models\CageEnvironmentLog;

class IoTService
{
    public function processEnvironmentData(
        int $cageId,
        array $data
    ): CageEnvironmentLog
    {
        return CageEnvironmentLog::create([
            'cage_id' => $cageId,
            'temperature' => $data['suhu'],
            'humidity' => $data['kelembapan'],
            'recorded_at' => now(),
        ]);
    }
}
