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

        $finalProperties = array_merge(
            $properties ?? [],
            [
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]
        );

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
}
