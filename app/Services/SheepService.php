<?php

namespace App\Services;

use App\Models\Sheep;

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

    public function deleteSheep($id)
    {
        $sheep = Sheep::findOrFail($id);
        $sheep->delete();
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
