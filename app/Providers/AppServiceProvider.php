<?php

namespace App\Providers;

use App\Models\MatingRecord;
use App\Models\Sheep;
use App\Models\WeightRecord;
use App\Observers\MatingRecordObserver;
use App\Observers\SheepObserver;
use App\Observers\WeightRecordObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sheep::observe(SheepObserver::class);
        WeightRecord::observe(WeightRecordObserver::class);
        MatingRecord::observe(MatingRecordObserver::class);
    }
}
