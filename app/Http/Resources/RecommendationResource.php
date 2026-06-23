<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecommendationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $sheep = $this['sheep'];

        return [
            'recommendation_id'      => $this['id'] ?? null,
            'sheep' => [
                'id'     => $sheep->id,
                'eartag' => $sheep->eartag,
                'gender' => $sheep->gender,
                'breed'  => $sheep->breed?->name,
            ],
            'inbreeding_coefficient' => $this['coi'],
            'inbreeding_percent'     => round($this['coi'] * 100, 4),
            'ewe_ebv'                => $this['ewe_ebv'],
            'ram_ebv'                => $this['ram_ebv'],
            'expected_ebv_offspring' => $this['expected_ebv'],
            'scores' => [
                'genetic' => $this['genetic_score'],
                'growth'  => $this['growth_score'],
                'health'  => $this['health_score'],
                'final'   => $this['final_score'],
            ],
        ];
    }
}
