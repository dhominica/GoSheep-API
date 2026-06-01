<?php

namespace App\Services;

use App\Models\HealthRecord;
use App\Models\Sheep;

class HealthRecordsService
{
    public function getHealthRecords($lastId = null, $limit = 10, $search = null)
    {
        $query = Sheep::query()
            ->select(['id', 'eartag', 'gender'])
            ->with([
                'latestHealth' => function ($q) {
                    $q->select([
                        'id',
                        'sheep_id',
                        'recorded_by',
                        'recorded_at',
                        'category',
                        'condition',
                        'severity',
                        'source',
                        'notes',
                    ])->with([
                        'recordedBy:id,name',
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

   public function getHealthRecordDetail(int $sheepId, $lastId = null, $limit = 10): array
   {
        $query = HealthRecord::query()
            ->where('sheep_id', $sheepId)
            ->with('recordedBy:id,name')
            ->orderByDesc('recorded_at')
            ->orderByDesc('id');

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

        $sheep = Sheep::findOrFail($sheepId);
        $sheep->setRelation('healthRecords', $records);

        return [
            'has_more'    => $hasMore,
            'next_cursor' => $nextCursor,
            'data'        => $sheep,
        ];
    }

    public function store(array $data): HealthRecord
    {
        $record = HealthRecord::create([
            'sheep_id'    => $data['sheep_id'],
            'recorded_by' => auth()->id(),
            'category'    => $data['category'],
            'condition'   => $data['condition'],
            'severity'    => $data['severity'],
            'recorded_at' => now(),
            'source'      => 'manual',
            'notes'       => $data['notes'] ?? null,
        ]);

        return $record->load('recordedBy:id,name');
    }

    public function getStatistics(): array
    {
        $topCategory = HealthRecord::query()
            ->where(
                'recorded_at',
                '>=',
                now()->subDays(30)
            )
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->first();

        // Get latest record per sheep for severity statistics
        $latestRecordIds = HealthRecord::query()
            ->whereNotIn('condition', [
                'heat_stress_risk',
                'heat_stress_critical',
            ])
            ->selectRaw('MAX(id) as id')
            ->groupBy('sheep_id')
            ->pluck('id')
            ->toArray();

        $severityStatistics = [];
        if (!empty($latestRecordIds)) {
            $severityStatistics = HealthRecord::query()
                ->whereIn('id', $latestRecordIds)
                ->selectRaw('severity, COUNT(*) as total')
                ->groupBy('severity')
                ->pluck('total', 'severity')
                ->toArray();
        }

        return [
            'total_records' => HealthRecord::count(),

            'records_this_week' => HealthRecord::query()
                ->where(
                    'recorded_at',
                    '>=',
                    now()->subDays(7)
                )
                ->count(),

            'top_category' => [
                'name' => $topCategory?->category,
                'total' => $topCategory?->total ?? 0,
            ],

            'severity_statistics' => [
                'normal' => $severityStatistics['normal'] ?? 0,
                'mild' => $severityStatistics['ringan'] ?? 0,
                'moderate' => $severityStatistics['sedang'] ?? 0,
                'severe' => $severityStatistics['berat'] ?? 0,
            ],
        ];
    }
}
