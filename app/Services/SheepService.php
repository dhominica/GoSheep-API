<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Sheep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SheepService
{
    public function getSheep($lastId = null, $limit = 10)
    {
        $query = Sheep::with([
            'breed',
            'latestWeight',
            'latestHealth'
        ])
        ->orderBy('id', 'desc');

        if ($lastId !== null) {
            $query->where('id', '<', $lastId);
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

        return [
            'data' => $sheep->values(),
            'has_more' => $hasMore,
            'next_cursor' => $hasMore && $sheep->count() > 0 ? $sheep->last()->id : null,
        ];
    }

    public function getSheepDetails($id)
    {
        $sheep = Sheep::with([
            'breed',
            'cage',
            'sire:id,eartag',
            'dam:id,eartag',
            'latestWeight',
            'latestHealth',
        ])->findOrFail($id);

        // mapping status_ui (biar konsisten dengan list)
        $sheep->status_ui = $this->mapStatusUi($sheep->latestHealth);

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

    public function deleteSheep($id)
    {
        return DB::transaction(function () use ($id) {
            $sheep = Sheep::findOrFail($id);

            if ($sheep->cage_id) {
                $sheep->cage()->decrement('current_capacity');
            }

            $sheep->delete();

            return true;
        });
    }

    private function mapStatusUi($health)
    {
        if (!$health) return 'sehat';

        return match ($health->severity) {
            'warning' => 'at_risk',
            'critical' => 'sakit',
            default => 'sehat',
        };
    }

    public function createSheep(array $data)
    {
        return DB::transaction(function () use ($data){
            $sheep = Sheep::create([
                'eartag' => $data['eartag'],
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'eartag_color' => $data['eartag_color'],
                'breed_id' => $data['breed_id'] ?? null,
                'sire_id' => $data['sire_id'] ?? null,
                'dam_id' => $data['dam_id'] ?? null,
                'cage_id' => $data['cage_id'] ?? null,
                'status'=> $data['status'] ?? 'active',
            ]);

            if ($sheep->cage_id) {
                $sheep->cage()->increment('current_capacity');
            }

            $sheep->weightRecords()->create([
                'weight' => $data['initial_weight'],
                'recorded_by' => Auth::id(),
                'recorded_at' => now(),
            ]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'loggable_id' => $sheep->id,
                'loggable_type' => Sheep::class,
                'action' => 'created',
                'entity' => 'sheep',
                'description' => "Menambahkan domba baru dengan eartag {$sheep->eartag}",
                'properties' => [
                    'initial_weight' => $data['initial_weight'],
                    'health_status' => $data['health_status'] ?? 'sehat'
                ],
            ]);
            
            return $sheep->load(['breed', 'cage', 'latestWeight']);

        });
    }
}
