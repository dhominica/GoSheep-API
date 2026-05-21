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

    public function addMatingCheck(array $data)
    {

        $matingRecord = MatingRecord::find($data['mating_record_id']);
        if ($matingRecord) {
            $matingRecord->update([
            'result'   => $data['result'],
            'end_date' => $data['check_date'] // Ini yang bikin end_date otomatis berubah mengikuti tanggal cek terakhir!
            ]);
        }
        
        return DB::transaction(function () use ($data) {
            $check = MatingCheck::create([
                'mating_record_id' => $data['mating_record_id'],
                'check_date' => $data['check_date'],
            ]);

            if (isset($data['result']) && $data['result'] !== 'unknown') {
                $record = MatingRecord::findOrFail($data['mating_record_id']);
                $record->update([
                    'result' => $data['result'],
                    'actual_result_date' => $data['check_date'], 
                ]);
            }

            return $check;
        });
    }
}