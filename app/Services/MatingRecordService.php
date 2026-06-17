<?php

namespace App\Services;

use App\Models\MatingRecord;
use App\Models\MatingCheck;
use App\Models\Pregnancy;
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

        $matingCheck = MatingCheck::where('mating_record_id', $matingId)
            ->orderBy('check_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

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

        if ($matingRecord->result !== 'unknown') {
            throw ValidationException::withMessages([
                'result' => [
                    'Pemeriksaan kawin tidak dapat ditambahkan karena status perkawinan sudah ditentukan'
                ]
            ]);
        }

        if ($data['check_date'] < $matingRecord->mating_date) {
            throw ValidationException::withMessages([
                'check_date' => [
                    'Tanggal pemeriksaan harus setelah atau sama dengan tanggal perkawinan'
                ]
            ]);
        }

        if (empty($data['notes'])) {
            $data['notes'] = match ($data['result']) {
                'pregnant' => 'Domba menunjukkan tanda kehamilan',
                'not_pregnant' => 'Domba tidak menunjukkan tanda kehamilan',
                'failed' => 'Pemeriksaan perkawinan gagal atau tidak konklusif',
                default => 'Pemeriksaan perkawinan dilakukan',
            };
        }

        return DB::transaction(function () use ($matingId, $data, $matingRecord) {
            $check = MatingCheck::create([
                'mating_record_id' => $matingId,
                'check_date' => $data['check_date'],
                'notes' => $data['notes'],
            ]);

            $matingRecord->update([
                'result' => $data['result'],
                'end_date' => $data['check_date'],
            ]);

            if ($data['result'] === 'pregnant') {
                $exists = Pregnancy::where('mating_record_id', $matingRecord->id)->exists();
                if (!$exists) {
                    Pregnancy::create([
                        'mating_record_id' => $matingRecord->id,
                        'ewe_id' => $matingRecord->ewe_id,
                        'start_date' => $matingRecord->mating_date,
                        'expected_birth_date' => $data['expected_birth_date'] ?? null,
                        'status' => 'ongoing',
                        'notes' => null,
                    ]);
                }
            }

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

    public function updateMatingCheck(MatingCheck $matingCheck, array $data)
    {
        $matingRecord = $matingCheck->matingRecord;

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

        // Validate that this is the latest check
        $latestCheck = MatingCheck::where('mating_record_id', $matingCheck->mating_record_id)
            ->orderBy('check_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if ($latestCheck && $latestCheck->id !== $matingCheck->id) {
            throw ValidationException::withMessages([
                'check' => [
                    'Hanya pemeriksaan kawin terbaru yang dapat diubah'
                ]
            ]);
        }

        if (empty($data['notes'])) {
            $data['notes'] = match ($data['result']) {
                'pregnant' => 'Domba menunjukkan tanda kehamilan',
                'not_pregnant' => 'Domba tidak menunjukkan tanda kehamilan',
                'failed' => 'Pemeriksaan perkawinan gagal atau tidak konklusif',
                default => 'Pemeriksaan perkawinan dilakukan',
            };
        }

        $oldResult = $matingRecord->result;
        $newResult = $data['result'];

        $oldPregnancy = Pregnancy::where('mating_record_id', $matingRecord->id)->first();
        $oldExpectedBirthDate = $oldPregnancy?->expected_birth_date?->toDateString();

        $old = [
            'check_date' => $matingCheck->check_date,
            'notes' => $matingCheck->notes,
            'result' => $oldResult,
            'expected_birth_date' => $oldExpectedBirthDate,
        ];

        return DB::transaction(function () use ($matingCheck, $matingRecord, $data, $oldResult, $newResult, $old) {
            $matingCheck->update([
                'check_date' => $data['check_date'],
                'notes' => $data['notes'],
            ]);

            $matingRecord->update([
                'result' => $newResult,
                'end_date' => $data['check_date'],
            ]);

            if ($oldResult === 'pregnant' && $newResult !== 'pregnant') {
                Pregnancy::where('mating_record_id', $matingRecord->id)->delete();
            } elseif ($newResult === 'pregnant') {
                Pregnancy::updateOrCreate(
                    ['mating_record_id' => $matingRecord->id],
                    [
                        'ewe_id' => $matingRecord->ewe_id,
                        'start_date' => $matingRecord->mating_date,
                        'expected_birth_date' => $data['expected_birth_date'] ?? null,
                        'status' => 'ongoing',
                    ]
                );
            }

            $new = [
                'check_date' => $matingCheck->check_date,
                'notes' => $matingCheck->notes,
                'result' => $newResult,
                'expected_birth_date' => $data['expected_birth_date'] ?? null,
            ];

            $this->activityLogService->log(
                Auth::id(),
                $matingCheck,
                'updated',
                'mating_check',
                "Memperbarui pemeriksaan perkawinan domba dengan eartag {$matingRecord->ewe->eartag} dan {$matingRecord->ram->eartag}",
                [
                    'mating_record_id' => $matingRecord->id,
                    'old' => $old,
                    'new' => $new,
                ]
            );

            return $matingCheck;
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
