<?php

namespace App\Services;

use App\Models\Cage;
use App\Models\HealthRecord;

class HeatStressService
{
    public function evaluate(int $cageId): void
    {
        $cage = Cage::find($cageId);

        if (!$cage) {
            return;
        }

        $logs = $cage
            ->environmentLogs()
            ->where(
                'recorded_at',
                '>=',
                now()->subMinutes(20)
            )
            ->get();

        if ($logs->isEmpty()) {
            return;
        }

        $avgTemperature =
            $logs->avg('temperature');

        $avgHumidity =
            $logs->avg('humidity');

        $condition =
            $this->detectCondition(
                $avgTemperature,
                $avgHumidity
            );

        if ($condition === null) {
            return;
        }

        foreach ($cage->sheep as $sheep) {

          $lastRecord = $sheep
          ->healthRecords()
          ->where('source', 'iot')
          ->latest('recorded_at')
          ->first();

          if (
              $lastRecord &&
              $lastRecord->condition === $condition['condition'] &&
              $lastRecord->severity === $condition['severity']
          ) {
              continue;
          }

            HealthRecord::create([
                'sheep_id' => $sheep->id,
                'recorded_at' => now(),

                'category' => 'environment',

                'condition' => $condition['condition'],

                'severity' => $condition['severity'],

                'source' => 'iot',

                'notes' =>
                    "Suhu kandang: {$avgTemperature}°C, "
                    ."Kelembapan kandang: {$avgHumidity}%"
            ]);
        }
    }

    private function detectCondition(
    float $temperature,
    float $humidity
  ): ?array
  {
      if ($temperature >= 40) {
          return [
              'condition' => 'heat_stress_critical',
              'severity' => 'berat',
          ];
      }

      if ($temperature >= 35) {
          return [
              'condition' => 'heat_stress_risk',
              'severity' => 'sedang',
          ];
      }

      return null;
  }
}
