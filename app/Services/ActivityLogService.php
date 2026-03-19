<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
  public function log(
    int $userId,
    ?int $sheepId = null,
    string $category,
    ?array $oldData = null,
    ?array $newData = null,
    string $description
  ): ActivityLog {
      $newData = $newData ?? [];
      $newData['ip'] = Request::ip();
      $newData['user_agent'] = Request::userAgent();

      $description = $description ?? ucfirst($category) . ' activity by user ID ' . $userId;

      return ActivityLog::create([
          'user_id' => $userId,
          'sheep_id' => $sheepId ? $sheepId : null,
          'category' => $category,
          'old_data' => $oldData ? json_encode($oldData) : null,
          'new_data' => $newData ? json_encode($newData) : null,
          'description' => $description,
      ]);
  }
}
