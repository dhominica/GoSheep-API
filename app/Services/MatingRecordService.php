<?php

namespace App\Services;

use App\Models\MatingRecord;
use App\Models\MatingCheck;
use App\Models\Sheep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MatingRecordService
{
    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function getMatingRecords($lastId = null, $limit = 10, $search = null)
    {
        $query = MatingRecord::with(['ewe', 'ram']);

        if ($lastId !== null) {
            $query->where('id', '<', $lastId);
        }

        if ($search) {
            $query->whereHas('ewe', function ($q) use ($search) {
                $q->where('eartag', 'like', "%$search%");
            })->orWhereHas('ram', function ($q) use ($search) {
                $q->where('eartag', 'like', "%$search%");
            });
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

    public function getMatingCheck(int $matingId)
    {
        $matingRecord = MatingRecord::find($matingId);

        if (!$matingRecord) {
            throw new NotFoundHttpException(
                'Perkawinan domba tidak ditemukan'
            );
        }

        $matingCheck = MatingCheck::where('mating_record_id', $matingId)->get();

        return $matingCheck;
    }

    public function addMatingCheck(int $matingId, array $data)
    {
        $matingRecord = MatingRecord::find($matingId);

        if (!$matingRecord) {
            throw new NotFoundHttpException(
                'Perkawinan domba tidak ditemukan'
            );
        }

        if ($data['check_date'] < $matingRecord->mating_date) {
            throw ValidationException::withMessages([
                'check_date' => [
                    'Tanggal pemeriksaan harus setelah atau sama dengan tanggal perkawinan'
                ]
            ]);
        }

        return DB::transaction(function () use ($matingId, $data, $matingRecord) {
            $check = MatingCheck::create([
                'mating_record_id' => $matingId,
                'check_date' => $data['check_date'],
                'notes' => $data['notes'] ?? null,
            ]);

            $matingRecord->update([
                'result' => $data['result'],
                'end_date' => $data['check_date'],
            ]);

            $this->activityLogService->log(
                Auth::id(),
                $check,
                'created',
                'mating_check',
                "Menambahkan pemeriksaan untuk perkawinan domba dengan eartag {$matingRecord->ewe->eartag} dan {$matingRecord->ram->eartag}",
                [
                    'mating_record_id' => $matingRecord->id,
                    'check_date' => $check->check_date,
                    'result' => $data['result'],
                ]
            );

            return $check;
        });
    }

    public function getMatedSheep(int $sheepId)
    {
        $sheepExists = Sheep::where('id', $sheepId)->exists();
        if (!$sheepExists) {
            throw new NotFoundHttpException('Domba tidak ditemukan');
        }

        return MatingRecord::with(['ewe', 'ram'])
            ->where('ewe_id', $sheepId)
            ->orWhere('ram_id', $sheepId)
            ->orderBy('mating_date', 'desc')
            ->get();
    }

    public function getMatingRecord(int $id)
    {
        $matingRecord = MatingRecord::with(['ewe', 'ram'])->find($id);

        if (!$matingRecord) {
            throw new NotFoundHttpException('Perkawinan domba tidak ditemukan');
        }

        return $matingRecord;
    }
}
