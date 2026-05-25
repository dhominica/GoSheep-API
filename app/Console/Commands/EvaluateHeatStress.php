<?php

namespace App\Console\Commands;

use App\Models\Cage;
use App\Services\HeatStressService;
use Illuminate\Console\Command;

class EvaluateHeatStress extends Command
{
    protected $signature = 'heat:evaluate';

    protected $description = 'Evaluate heat stress';

    public function handle(HeatStressService $service)
    {
        $this->info('Starting heat evaluation...');

        Cage::chunk(
            100,
            function ($cages) use ($service) {

                foreach ($cages as $cage) {

                    $this->info(
                        "Evaluating cage {$cage->id}"
                    );

                    $service->evaluate(
                        $cage->id
                    );
                }
            }
        );

        $this->info('Heat evaluation finished');
    }
}
