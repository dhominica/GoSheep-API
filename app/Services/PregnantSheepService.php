<?php

namespace App\Services;

use App\Models\Birth;
use App\Models\Pregnancy;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;

class PregnantSheepService
{
    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function getPregnancySummary()
    {
        $pregnantSheep = Pregnancy::query()
          ->where('status', 'ongoing')
          ->count();

        $gaveBirth = Pregnancy::query()
          ->where('status', 'birthed')
          ->count();

        $miscarriages = Pregnancy::query()
          ->where('status', 'miscarried')
          ->count();

        return [
          'pregnant_sheep' => $pregnantSheep,
          'gave_birth'     => $gaveBirth,
          'miscarriages'   => $miscarriages,
        ];
    }

    public function getPregnancies($lastId = null, $limit = 10, $search = null)
    {
        $query = Pregnancy::select([
          'id',
          'mating_record_id',
          'ewe_id',
          'start_date',
          'expected_birth_date',
          'end_date',
          'status',
          'notes',
        ])->with([
            'ewe:id,eartag',
            'matingRecord:id,ram_id',
            'matingRecord.ram:id,eartag',
            'birth',
          ])
          ->orderBy('id', 'desc');

        if ($lastId !== null) {
            $query->where('id', '<', $lastId);
        }

        if ($search) {
            $query->whereHas('ewe', function ($q) use ($search) {
                $q->where('eartag', 'like', "%{$search}%");
            });
        }

        $pregnancies = $query->limit($limit + 1)->get();

        $hasMore = $pregnancies->count() > $limit;

        if ($hasMore) {
            $pregnancies = $pregnancies->take($limit);
        }

        $nextCursor = $hasMore && $pregnancies->count() > 0
                    ? $pregnancies->last()->id
                    : null;

        return [
            'data'        => $pregnancies,
            'has_more'    => $hasMore,
            'next_cursor' => $nextCursor,
        ];
    }

    public function update(Pregnancy $pregnancy, array $data): Pregnancy
    {
        $oldStatus = $pregnancy->status;
        $newStatus = $data['status'];

        $old = [
            'expected_birth_date' => $pregnancy->expected_birth_date?->toDateString(),
            'end_date'            => $pregnancy->end_date?->toDateString(),
            'status'              => $oldStatus,
            'notes'               => $pregnancy->notes,
        ];

        $pregnancy->update([
            'expected_birth_date' => $data['expected_birth_date'],
            'status'              => $newStatus,
            'end_date'            => in_array($newStatus, ['birthed', 'miscarried'])
                                     ? ($data['end_date'] ?? now()->toDateString())
                                     : null,
            'notes'               => $data['notes'] ?? null,
        ]);

        // --- Births sync logic ---
        if ($newStatus === 'birthed') {
            // Create or update birth record
            Birth::updateOrCreate(
                ['pregnancy_id' => $pregnancy->id],
                [
                    'total_lambs' => $data['total_lambs'],
                    'birth_notes' => $data['birth_notes'] ?? null,
                ]
            );
        } elseif ($oldStatus === 'birthed' && $newStatus !== 'birthed') {
            // Status changed away from 'birthed' → delete birth record
            Birth::where('pregnancy_id', $pregnancy->id)->delete();
        }

        $new = [
            'expected_birth_date' => $pregnancy->expected_birth_date?->toDateString(),
            'end_date'            => $pregnancy->end_date?->toDateString(),
            'status'              => $newStatus,
            'notes'               => $pregnancy->notes,
        ];

        $this->activityLogService->log(
            Auth::id(),
            $pregnancy,
            'updated',
            'pregnancy',
            "Memperbarui data kehamilan domba {$pregnancy->ewe->eartag}",
            [
                'pregnancy_id' => $pregnancy->id,
                'ewe_id'       => $pregnancy->ewe_id,
                'ewe_eartag'   => $pregnancy->ewe->eartag,
                'old'          => $old,
                'new'          => $new,
            ]
        );

        return $pregnancy->load(['ewe', 'matingRecord.ram', 'birth']);
    }
}

