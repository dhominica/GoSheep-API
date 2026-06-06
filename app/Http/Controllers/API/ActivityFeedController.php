<?php

namespace App\Http\Controllers\API;

use App\Services\ActivityLogService;
use App\Http\Resources\ActivityFeedResource;
use Illuminate\Http\Request;

class ActivityFeedController extends BaseController
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    public function index(Request $request)
    {
        $result = $this->activityLogService->getActivityFeed(
            $request->input('last_id'),
            $request->input('limit', 10),
        );

        return $this->successCursorPaginated(
            ActivityFeedResource::collection($result['data']),
            $result['has_more'],
            $result['next_cursor'],
            'Activity feed berhasil diambil'
        );
    }
}
