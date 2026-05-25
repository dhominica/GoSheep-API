<?php

namespace App\Services;

use App\Models\HealthRecord;

class HealthRecordsService
{
    public function getHealthRecords($sheepId = null, $lastId = null, $limit = 10)
    {
        $query = HealthRecord::with(['sheep', 'recordedBy']);
        
        if ($sheepId) {
            $query->where('sheep_id', $sheepId);
        }

        if ($lastId) {
            $query->where('id', '<', $lastId);
        }

        $records = $query->orderBy('id', 'desc')->limit($limit + 1)->get();
        $hasMore = $records->count() > $limit;
        
        if ($hasMore) {
            $records->pop();
        }

        $nextCursor = $records->last()->id;
        return [
            'data' => $records,
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
        ];
    }

    public function store(array $data)
    {
        return HealthRecord::create($data);
    }

}