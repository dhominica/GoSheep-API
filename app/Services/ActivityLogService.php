<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public function log(
        int $userId,
        $model,
        string $action,
        string $entity,
        string $description,
        ?array $properties = null
    ): ActivityLog {

        if (!$model || !isset($model->id)) {
            throw new \InvalidArgumentException('Model tidak valid untuk logging');
        }

        $finalProperties = $properties ?? [];

        return ActivityLog::create([
            'user_id' => $userId,
            'loggable_id' => $model->id,
            'loggable_type' => $model->getMorphClass(),
            'action' => $action,
            'entity' => $entity,
            'description' => $description,
            'properties' => $finalProperties,
        ]);
    }

    public function getActivityFeed($lastId = null, $limit = 10)
    {
        $query = ActivityLog::with(['user:id,name'])
            ->orderBy('id', 'desc');

        if ($lastId !== null) {
            $query->where('id', '<', $lastId);
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
