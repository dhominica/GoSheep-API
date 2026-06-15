<?php

namespace App\Services;

use App\Models\Pregnancy;

class PregnantSheepService
{
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
        'gave_birth' => $gaveBirth,
        'miscarriages' => $miscarriages,
      ];
  }

  public function getPregnancies($lastId = null, $limit = 10, $search = null)
  {
      $query = Pregnancy::select([
        'id',
        'ewe_id',
        'start_date',
        'expected_birth_date',
        'status'
      ])->with([
          'ewe:id,eartag',
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
          'data' => $pregnancies,
          'has_more' => $hasMore,
          'next_cursor' => $nextCursor,
      ];
  }
}
