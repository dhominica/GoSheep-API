<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'weight' => (float) $this->weight,
            'recorded_by' => $this->whenLoaded('recordedBy')
                ? [
                    'id' => $this->recordedBy->id,
                    'name' => $this->recordedBy->name,
                ]
                : null,
            'recorded_at' => $this->recorded_at,
        ];
    }
}
