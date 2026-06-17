<?php

namespace App\Services;

use App\Models\Sheep;
use App\Models\WeightRecord;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;

class WeightRecordService
{
    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function getSheepWeight($lastId = null, $limit = 10, $search = null)
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

    public function getWeightRecord(int $sheepId, $lastId = null, $limit = 10): array
    {
        $query = WeightRecord::query()
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
        $sheep->setRelation('weightRecords', $records);

        return [
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
            'data' => $sheep,
        ];
    }

    public function store(array $data): WeightRecord
    {
        $record = WeightRecord::create([
            'sheep_id' => $data['sheep_id'],
            'weight' => $data['weight'],
            'recorded_by' => auth()->id(),
            'recorded_at' => now(),
        ]);

        $this->activityLogService->log(
            Auth::id(),
            $record,
            'created',
            'weight_record',
            "Mencatat timbangan untuk domba {$record->sheep->eartag}",
            [
                'sheep_id' => $record->sheep->id,
                'sheep_gender' => $record->sheep->gender,
                'sheep_eartag' => $record->sheep->eartag,
                'weight' => $record->weight,
            ],
        );

        return $record->load('recordedBy:id,name');
    }

    public function update(WeightRecord $record, array $data): WeightRecord
    {
        $oldWeight = $record->weight;
        $newWeight = $data['weight'];

        $record->update([
            'weight' => $newWeight,
        ]);

        $this->activityLogService->log(
            Auth::id(),
            $record,
            'updated',
            'weight_record',
            "Memperbarui timbangan domba {$record->sheep->eartag}",
            [
                'old' => [
                    'weight' => (float)$oldWeight,
                ],
                'new' => [
                    'weight' => (float)$newWeight,
                ],
            ]
        );

        return $record->load('recordedBy:id,name');
    }

    public function getMonthlyWeightStatistics(int $sheepId, ?int $year = null): array
    {
        $year = $year ?? now()->year;

        $records = WeightRecord::query()
            ->where('sheep_id', $sheepId)
            ->whereYear('recorded_at', $year)
            ->selectRaw('MONTH(recorded_at) as month, ROUND(AVG(weight), 2) as avg_weight')
            ->groupByRaw('MONTH(recorded_at)')
            ->orderByRaw('MONTH(recorded_at)')
            ->get()
            ->keyBy('month');

        $months = collect(range(1, 12))->map(function ($month) use ($records) {
            $record = $records->get($month);

            return [
                'month'      => $month,
                'month_name' => \Carbon\Carbon::create()->month($month)->translatedFormat('F'),
                'avg_weight' => (float) $record?->avg_weight,
            ];
        });

        $sheep = Sheep::findOrFail($sheepId);

        return [
            'year'       => $year,
            'sheep'      => $sheep->only(['eartag']),
            'statistics' => $months,
        ];
    }

    public function getAllSheepMonthlyStatistics(?int $year = null): array
    {
        $year = $year ?? now()->year;

        $records = WeightRecord::query()
            ->whereYear('recorded_at', $year)
            ->selectRaw('MONTH(recorded_at) as month, ROUND(AVG(weight), 2) as avg_weight')
            ->groupByRaw('MONTH(recorded_at)')
            ->orderByRaw('MONTH(recorded_at)')
            ->get()
            ->keyBy('month');

        $months = collect(range(1, 12))->map(function ($month) use ($records) {
            $record = $records->get($month);

            return [
                'month'      => $month,
                'month_name' => \Carbon\Carbon::create()->month($month)->translatedFormat('F'),
                'avg_weight' => (float) $record?->avg_weight,
            ];
        });

        return [
            'year'       => $year,
            'statistics' => $months,
        ];
    }
}
