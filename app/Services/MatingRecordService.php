<?php

namespace App\Services;

use App\Models\MatingRecord;
use App\Models\MatingCheck;
use Illuminate\Support\Facades\DB;

class MatingRecordService
{
    public function getMatingRecords($lastId, $limit = 10, $search = null)
    {
        $query = MatingRecord::with(['ewe', 'ram', 'checks' => function ($q) {
            $q->latest('check_date');
        }]);

        if ($search) {
            $query->whereHas('ewe', function ($q) use ($search) {
                $q->where('eartag', 'like', "%$search%");
            })->orWhereHas('ram', function ($q) use ($search) {
                $q->where('eartag', 'like', "%$search%");
            });
        }

        if ($lastId) {
            $query->where('id', '<', $lastId);
        }

        $records = $query->orderBy('id', 'desc')->limit($limit + 1)->get();
        $hasMore = $records->count() > $limit;

        if ($hasMore) {
            $records->pop();
        }

        $nextCursor = $records->last() ? $records->last()->id : null;

        return [
            'data' => $records,
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
        ];
    }

    public function getStats(): array
    {
        return [
            'total_riwayat' => MatingRecord::count(),
            'total_bunting' => MatingRecord::where('result', 'pregnant')->count(),
            'total_proses'  => MatingRecord::where('result', 'unknown')->count(),
            'total_gagal'   => MatingRecord::whereIn('result', ['not_pregnant', 'failed'])->count(),
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
