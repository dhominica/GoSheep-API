<?php

namespace App\Services;

use App\Models\Cage;
use App\Models\Sheep;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SheepService
{

    protected ActivityLogService $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function getSheep(
    $lastId = null,
    $limit = 10,
    $search = null
    )
    {
        $query = Sheep::with([
            'breed',
            'latestWeight',
            'latestHealth'
        ])->orderBy('id', 'desc');

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

        $sheep = $query->limit($limit + 1)->get();

        $hasMore = $sheep->count() > $limit;

        if ($hasMore) {
            $sheep = $sheep->take($limit);
        }

        $sheep->transform(function ($item) {
            $item->status_ui = $this->mapStatusUi($item->latestHealth);
            return $item;
        });

        $nextCursor = $hasMore && $sheep->count() > 0
                    ? $sheep->last()->id
                    : null;

        return [
            'data' => $sheep->values(),
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
        ];
    }

    public function getSheepDetails(int $id)
    {
        $sheep = Sheep::with([
            'breed',
            'cage',
            'sire:id,eartag',
            'dam:id,eartag',
            'latestWeight',
            'latestHealth',
        ])->findOrFail($id);

        $sheep->status_ui = $this->mapStatusUi($sheep->latestHealth);

        return $sheep;
    }

    public function scanSheep(string $earTag)
    {
        $sheep = Sheep::with([
            'breed',
            'cage',
            'sire:id,eartag',
            'dam:id,eartag',
            'latestWeight',
            'latestHealth',
        ])
        ->where('eartag', $earTag)
        ->first();

        if (!$sheep) {
            throw new NotFoundHttpException(
            'Domba tidak ditemukan'
            );
        }

        $sheep->status_ui = $this->mapStatusUi(
            $sheep->latestHealth
        );

        return $sheep;
    }


    public function healthStatusStats()
    {
        $sheep = Sheep::with('latestHealth')->get();

        $healthy = 0;
        $atRisk = 0;
        $sick = 0;

        foreach ($sheep as $item) {
        $status = $this->mapStatusUi($item->latestHealth);

            if ($status === 'sehat') {
                $healthy++;
            } elseif ($status === 'at_risk') {
                $atRisk++;
            } elseif ($status === 'sakit') {
                $sick++;
            }
        }

        return [
            'healthy_total' => $healthy,
            'at_risk_total' => $atRisk,
            'sick_total' => $sick,
        ];
    }

    public function deleteSheep(int $id)
    {
        return DB::transaction(function () use ($id) {
            $sheep = Sheep::findOrFail($id);

            if ($sheep->cage_id) {
                $sheep->cage()->decrement('current_capacity');
            }

            $sheep->delete();

            $this->activityLogService->log(
                Auth::id(),
                $sheep,
                'delete',
                'sheep',
                "Menghapus domba dengan eartag {$sheep->eartag}",
                [
                    'snapshot' => [
                        'breed' => $sheep->breed->name ?? '-',
                        'gender' => $sheep->gender,
                        'cage' => $sheep->cage->name ?? '-'
                    ]
                ]
            );

            return true;
        });
    }

    private function mapStatusUi($health)
    {
        if (!$health) {
            return 'sehat';
        }

        return match ($health->severity) {

            'ringan',
            'sedang',
            'berat'
                => 'sakit',

            default
                => 'sehat',
        };
    }

   public function createSheep(array $data)
   {
       return DB::transaction(function () use ($data) {

         if (!empty($data['sire_id'])) {
            $sire = Sheep::find($data['sire_id']);

            if (!$sire) {
                throw new \Exception('Sire tidak ditemukan');
            }

            if ($sire->gender !== 'male') {
                throw new \Exception('Sire harus berjenis kelamin jantan');
            }
         }

            if (!empty($data['dam_id'])) {
                $dam = Sheep::find($data['dam_id']);

                if (!$dam) {
                    throw new \Exception('Dam tidak ditemukan');
                }

                if ($dam->gender !== 'female') {
                    throw new \Exception('Dam harus berjenis kelamin betina');
                }
            }

            if (!empty($data['sire_id']) && !empty($data['dam_id'])) {
                if ($data['sire_id'] == $data['dam_id']) {
                    throw new \Exception('Sire dan Dam tidak boleh sama');
                }
            }

            if (!empty($data['cage_id'])) {
                $cage = Cage::find($data['cage_id']);

                if (!$cage) {
                    throw new \Exception('Kandang tidak ditemukan');
                }

                if ($cage->current_capacity >= $cage->max_capacity) {
                    throw new \Exception('Kandang sudah penuh');
                }
            }

            $sheep = Sheep::create([
                'eartag' => $data['eartag'],
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'eartag_color' => $data['eartag_color'],
                'breed_id' => $data['breed_id'] ?? null,
                'sire_id' => $data['sire_id'] ?? null,
                'dam_id' => $data['dam_id'] ?? null,
                'cage_id' => $data['cage_id'] ?? null,
                'status' => $data['status'] ?? 'active',
            ]);

            $sheep->weightRecords()->create([
                'sheep_id' => $sheep->id,
                'weight' => $data['weight'],
                'recorded_by' => Auth::id(),
                'recorded_at' => now(),
            ]);

            $sheep->healthRecords()->create([
                'sheep_id' => $sheep->id,
                'recorded_by' => Auth::id(),
                'recorded_at' => now(),
                'category' => $data['category'],
                'condition' => $data['condition'],
                'severity' => $data['severity'] ?? 'normal',
                'source' => 'manual',
                'notes' => $data['notes'] ?? null,
            ]);

            $sheep->load([
                'breed',
                'latestWeight',
                'latestHealth',
            ]);

            $sheep->status_ui = $this->mapStatusUi($sheep->latestHealth);

            $this->activityLogService->log(
                Auth::id(),
                $sheep,
                'created',
                'sheep',
                "Menambahkan domba baru dengan eartag {$sheep->eartag}",
                [
                    'weight' => $data['weight'],
                    'health_status' => $sheep->latestHealth->condition ?? 'normal',
                ]
            );

            return $sheep;
        });
    }
}
