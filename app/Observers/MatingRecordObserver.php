<?php

namespace App\Observers;

use App\Models\MatingRecord;
use App\Models\MatingRecommendation;

class MatingRecordObserver
{
    public function created(MatingRecord $matingRecord): void
    {
        // Invalidate semua rekomendasi aktif untuk ewe ini
        // Karena ewe sudah terkunci dengan ram tertentu,
        // semua rekomendasi lain untuk ewe ini tidak relevan lagi
        MatingRecommendation::where('ewe_id', $matingRecord->ewe_id)
            ->where('is_valid', true)
            ->update(['is_valid' => false]);
    }
}
