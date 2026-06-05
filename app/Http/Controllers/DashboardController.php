<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $totalPeternak = \App\Models\User::where('role', 'peternak')->count();
        $totalKandang = \App\Models\Cage::count();
        
        $activeSheep = \App\Models\Sheep::where('status', 'active')->get();
        $totalDomba = $activeSheep->count();
        
        $activities = \App\Models\ActivityLog::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        // Calculate Kapasitas Kandang Terisi
        $totalMaxCapacity = \App\Models\Cage::sum('max_capacity');
        $totalSheepInCages = \App\Models\Sheep::whereNotNull('cage_id')->where('status', 'active')->count();
        $capacityPercentage = $totalMaxCapacity > 0 ? round(($totalSheepInCages / $totalMaxCapacity) * 100) : 0;

        // Calculate Kesehatan Ternak (Prima)
        $sickSheepCount = \App\Models\HealthRecord::whereIn('severity', ['warning', 'critical'])
            ->whereIn('sheep_id', $activeSheep->pluck('id'))
            ->where('created_at', '>=', now()->subDays(14)) // sick in last 14 days
            ->distinct('sheep_id')
            ->count('sheep_id');
            
        $healthyPercentage = $totalDomba > 0 ? round((($totalDomba - $sickSheepCount) / $totalDomba) * 100) : 100;

        // Calculate Average Weight per Month (Last 6 Months)
        $weightChartData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $avgWeight = \App\Models\WeightRecord::whereBetween('recorded_at', [$monthStart, $monthEnd])->avg('weight');
            
            $weightChartData->push([
                'month' => $date->translatedFormat('M'),
                'avg_weight' => $avgWeight ? round($avgWeight, 2) : null
            ]);
        }

        // Remove trailing months that have no data
        while ($weightChartData->isNotEmpty() && is_null($weightChartData->last()['avg_weight'])) {
            $weightChartData->pop();
        }

        return view('dashboard', compact('totalPeternak', 'totalKandang', 'totalDomba', 'activities', 'capacityPercentage', 'healthyPercentage', 'weightChartData'));
    }
}
