<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OverviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_sheep' => $this['total_sheep'],
            'pregnant_sheep' => $this['pregnant_sheep'],
            'upcoming_births' => $this['upcoming_births'],
            'pregnancy_rate' => $this['pregnancy_rate'],
        ];
    }
}
