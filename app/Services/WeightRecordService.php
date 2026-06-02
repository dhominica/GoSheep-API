<?php

namespace App\Services;

use App\Models\Sheep;

class WeightRecordService
{
  public function getWeight($lastId = null, $limit = 10, $search = null)
  {
    $query = Sheep::query()
      ->select(['id', 'eartag', 'gender'])
      ->with([
        'latestWeight' => function ($q) {
          $q->select([
            'id',
            'sheep_id',
            'weight',
            'recorded_by',
            'recorded_at'
          ])->with([
            'recordedBy:id,name'
          ]);
        }
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

        $records = $query->limit($limit + 1)->get();

        $hasMore = $records->count() > $limit;

        if ($hasMore) {
            $records = $records->take($limit);
        }

        $nextCursor = $hasMore && $records->count() > 0
                    ? $records->last()->id
                    : null;

        return [
            'data' => $records,
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
        ];
  }
}
