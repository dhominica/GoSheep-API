<?php

namespace App\Services;

use App\Models\MatingRecord;
use App\Models\MatingCheck;
use Illuminate\Support\Facades\DB;

class MatingRecordService
{
    public function getMatingRecords($lastId = null, $limit = 10, $search = null)
    {
        $query = MatingRecord::with(['ewe', 'ram']);

        if ($search) {
            $query->whereHas('ewe', function ($q) use ($search) {
                $q->where('eartag', 'like', "%$search%");
            })->orWhereHas('ram', function ($q) use ($search) {
                $q->where('eartag', 'like', "%$search%");
            });
        }

        if ($lastId !== null) {
            $query->where('id', '<', $lastId);
        }

        $records = $query
            ->orderBy('id', 'desc')
            ->limit($limit + 1)
            ->get();

        $hasMore = $records->count() > $limit;

        if ($hasMore) {
            $records = $records->take($limit);
        }

        $nextCursor = $hasMore && $records->count() > 0
                    ? $records->last()->id
                    : null;
        return [
            'data' => $records->values(),
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
        ];
    }

    public function getStats(): array
    {
        return [
            'pregnant_total'      => MatingRecord::where('result', 'pregnant')->count(),
            'unknown_total'       => MatingRecord::where('result', 'unknown')->count(),
            'not_pregnant_total'  => MatingRecord::where('result', 'not_pregnant')->count(),
            'failed_total'        => MatingRecord::where('result', 'failed')->count(),
        ];
    }

    public function addMatingCheck(array $data)
    {
        return DB::transaction(function () use ($data) {
            $record = MatingRecord::findOrFail($data['mating_record_id']);

            $check = MatingCheck::create([
                'mating_record_id' => $record->id,
                'check_date' => $data['check_date'],
            ]);

            $updates = [
                'result' => $data['result'],
                'end_date' => $data['check_date'],
            ];

            if ($data['result'] !== 'unknown') {
                $updates['actual_result_date'] = $data['check_date'];
            }

            $record->update($updates);

            return $check;
        });
    }
}
