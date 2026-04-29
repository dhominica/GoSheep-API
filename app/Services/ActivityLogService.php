<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

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
      $extraData = [
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
      ];

      $finalProperties = array_merge($extraData, $properties ?? []);

      return ActivityLog::create([
          'user_id' => $userId,
          'loggable_id' => $model->id,
          'loggable_type' => get_class($model),
          'action' => $action,
          'entity' => $entity,
          'description' => $description,
          'properties' => $finalProperties,
      ]);
  }
}
