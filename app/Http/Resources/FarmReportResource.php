<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'summary'               => $this->resource['summary'],
            'population_per_month'  => $this->resource['population_per_month'],
            'age_distribution'      => $this->resource['age_distribution'],
            'health_stats'          => $this->resource['health_stats'],
        ];
    }
}
