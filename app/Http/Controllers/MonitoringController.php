<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\CageEnvironmentLog;
use Illuminate\Http\JsonResponse;

class MonitoringController extends Controller
{
    public function index()
    {
        $cages = Cage::select('id', 'name')->orderBy('name')->get();

        return view('monitoring.index', compact('cages'));
    }

    public function history(int $cageId): JsonResponse
    {
        $logs = CageEnvironmentLog::where('cage_id', $cageId)
            ->where('recorded_at', '>=', now()->subHours(24))
            ->orderBy('recorded_at')
            ->get(['temperature', 'humidity', 'recorded_at']);
        
        return response()->json($logs);
    }
}
