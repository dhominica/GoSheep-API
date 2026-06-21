<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SheepBreedingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'eartag'         => $this->eartag,
            'gender'         => $this->gender,
            'breed'          => $this->breed?->name,
            'eartag_color'   => $this->eartag_color,
            'age_days'       => (int) $this->birth_date->diffInDays(now()),
            'age_months'     => round($this->birth_date->diffInDays(now()) / 30, 1),
            'is_eligible'    => $this->is_eligible,
            'breeding_status'=> $this->breeding_status,
            'ebv' => [
                'weight'     => $this->sheepFeature?->EBV_Bobot,
                'growth'       => $this->sheepFeature?->EBV_ADG,
                'health' => $this->sheepFeature?->EBV_Kesehatan,
            ],
        ];
    }
}
