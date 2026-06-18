<?php

namespace App\Services;

use App\Models\Sheep;

class InactiveSheepService
{
    public function getInactiveSheep(
        $lastId = null,
        $limit = 10,
        $search = null
    ) {
        $query = Sheep::with([
            'breed',
            'latestWeight',
            'cage'
        ])
        ->whereIn('status', [
            'dead',
            'sold',
            'inactive'
        ])
        ->orderBy('id', 'desc');

        if ($lastId !== null) {
            $query->where('id', '<', $lastId);
        }

        if ($search) {
            $query->where(
                'eartag',
                'like',
                "%{$search}%"
            );
        }

        $sheep = $query->limit($limit + 1)->get();

        $hasMore = $sheep->count() > $limit;

        if ($hasMore) {
            $sheep = $sheep->take($limit);
        }

        $nextCursor = $hasMore && $sheep->count() > 0
            ? $sheep->last()->id
            : null;

        return [
            'data' => $sheep->values(),
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
        ];
    }
}
