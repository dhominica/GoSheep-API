<?php

namespace App\Observers;

use App\Models\Sheep;
use App\Models\SheepFeature;

class SheepObserver
{
    /**
     * Handle the Sheep "created" event.
     */
    public function created(Sheep $sheep): void
    {
        SheepFeature::create([
            'sheep_id' => $sheep->id,
            'computed_at' => now(),
        ]);
    }

    /**
     * Handle the Sheep "updated" event.
     */
    public function updated(Sheep $sheep): void
    {
        //
    }

    /**
     * Handle the Sheep "deleted" event.
     */
    public function deleted(Sheep $sheep): void
    {
        //
    }

    /**
     * Handle the Sheep "restored" event.
     */
    public function restored(Sheep $sheep): void
    {
        //
    }

    /**
     * Handle the Sheep "force deleted" event.
     */
    public function forceDeleted(Sheep $sheep): void
    {
        //
    }
}
