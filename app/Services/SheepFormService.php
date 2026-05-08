<?php
namespace App\Services;

use App\Models\Breed;
use App\Models\Cage;
use App\Models\Sheep;

class SheepFormService
{
    public function getBreeds()
    {
        return Breed::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function getCages()
    {
        return Cage::query()
            ->select([
                'id',
                'name',
                'current_capacity',
                'max_capacity',
            ])
            ->orderBy('name')
            ->get();
    }

     public function getSires(
        ?int $lastId = null,
        int $limit = 20,
        ?string $search = null
    ) {
        $query = Sheep::query()
            ->select('id', 'eartag')
            ->where('gender', 'male')
            ->orderBy('id', 'desc');

        if ($lastId) {
            $query->where('id', '<', $lastId);
        }

        if ($search) {
            $query->where(
                'eartag',
                'like',
                "%{$search}%"
            );
        }

        $sires = $query->limit($limit + 1)->get();

        $hasMore = $sires->count() > $limit;

        if ($hasMore) {
            $sires = $sires->take($limit);
        }

        return [
            'data' => $sires->values(),
            'has_more' => $hasMore,
            'next_cursor' => $hasMore
                ? $sires->last()->id
                : null,
        ];
    }

    public function getDams(
        ?int $lastId = null,
        int $limit = 20,
        ?string $search = null
    ) {
        $query = Sheep::query()
            ->select('id', 'eartag')
            ->where('gender', 'female')
            ->orderBy('id', 'desc');

        if ($lastId) {
            $query->where('id', '<', $lastId);
        }

        if ($search) {
            $query->where(
                'eartag',
                'like',
                "%{$search}%"
            );
        }

        $dams = $query->limit($limit + 1)->get();

        $hasMore = $dams->count() > $limit;

        if ($hasMore) {
            $dams = $dams->take($limit);
        }

        return [
            'data' => $dams->values(),
            'has_more' => $hasMore,
            'next_cursor' => $hasMore
                ? $dams->last()->id
                : null,
        ];
    }
}
