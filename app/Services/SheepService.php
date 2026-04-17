<?php

namespace App\Services;

use App\Models\Sheep;
use Illuminate\Support\Facades\DB;

class SheepService
{
    public function getSheep($lastId = null, $limit = 10)
    {
        $query = Sheep::with([
            'breed',
            'latestWeight',
            'latestHealth'
        ])
        ->orderBy('id', 'desc');

        if ($lastId !== null) {
            $query->where('id', '<', $lastId);
        }

        $sheep = $query->limit($limit + 1)->get();

        $hasMore = $sheep->count() > $limit;
        if ($hasMore) {
            $sheep = $sheep->take($limit);
        }

        $sheep->transform(function ($item) {
            $item->status_ui = $this->mapStatusUi($item->latestHealth);
            return $item;
        });

        return [
            'data' => $sheep->values(),
            'has_more' => $hasMore,
            'next_cursor' => $hasMore && $sheep->count() > 0 ? $sheep->last()->id : null,
        ];
    }

    public function healthStatusStats()
    {
        $sheep = Sheep::with('latestHealth')->get();

        $healthy = 0;
        $atRisk = 0;
        $sick = 0;

        foreach ($sheep as $item) {
        $status = $this->mapStatusUi($item->latestHealth);

            if ($status === 'sehat') {
                $healthy++;
            } elseif ($status === 'at_risk') {
                $atRisk++;
            } elseif ($status === 'sakit') {
                $sick++;
            }
        }

        return [
            'healthy_total' => $healthy,
            'at_risk_total' => $atRisk,
            'sick_total' => $sick,
        ];
    }

    public function deleteSheep($id)
    {
        return DB::transaction(function () use ($id) {
            $sheep = Sheep::findOrFail($id);

            if ($sheep->cage_id) {
                $sheep->cage()->decrement('current_capacity');
            }

            $sheep->delete();

            return true;
        });
    }

    private function mapStatusUi($health)
    {
        if (!$health) return 'sehat';

        return match ($health->severity) {
            'warning' => 'at_risk',
            'critical' => 'sakit',
            default => 'sehat',
        };
    }
}
