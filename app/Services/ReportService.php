<?php
namespace App\Services;

use App\Models\Sheep;
use App\Models\Cage;
use App\Models\MatingRecord;
use Carbon\Carbon;

class ReportService
{
    protected SheepService $sheepService;

    public function __construct(SheepService $sheepService)
    {
        $this->sheepService = $sheepService;
    }

    public function getFarmReport(): array
    {
        return [
            'summary' => $this->getSummary(),
            'population_per_month' => $this->getPopulationPerMonth(),
            'age_distribution' => $this->getAgeDistribution(),
            'health_stats' => $this->sheepService->healthStatusStats(),
        ];
    }

    private function getSummary(): array
    {
        $health = $this->sheepService->healthStatusStats();
        $totalHealth = $health['healthy_total']
                       + $health['at_risk_total']
                       + $health['sick_total'];
        $healthyPercentage = $totalHealth > 0 ? round($health['healthy_total'] / $totalHealth * 100, 1): 0;
        return [
            'total_sheep' => Sheep::where('status', 'active')->count(),
            'total_cages' => Cage::count(),
            'healthy_percentage' => $healthyPercentage,
            'breeding_total' => MatingRecord::count(),
        ];
    }

    private function getPopulationPerMonth(): array
    {
        $result = [];

        for ($i = 5; $i >=0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $total = Sheep::whereYear('created_at', $date->year)
                          ->whereMonth('created_at', $date->month)
                          ->count();
            
            $result[] = [
                'month' => $date->format('M'),
                'total' => $total,
            ];
        }

        return $result;
    }

    private function getAgeDistribution(): array
    {
        $groups = [
            '0-6'   => 0,
            '7-12'  => 0,
            '13-18' => 0,
            '>18'   => 0,
        ];
        $sheeps = Sheep::whereNotNull('birth_date')->get(['id', 'birth_date']);

        foreach ($sheeps as $sheep) {
            $months = Carbon::parse($sheep->birth_date)->diffInMonths(Carbon::now());

            if ($months <=6) {
                $groups['0-6']++;
            } elseif ($months <=12) {
                $groups['7-12']++;
            } elseif ($months <= 18) {
                $groups['13-18']++;
            } else {
                $groups['>18']++;
            }
        }

        $result = [];
        foreach ($groups as $range => $total) {
            $result[] = ['range' => $range, 'total' => $total];
        }

        return $result;
    }
}