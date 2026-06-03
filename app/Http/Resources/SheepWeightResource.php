<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SheepWeightResource extends JsonResource
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
            'eartag' => $this->eartag,
            'gender' => $this->gender,
            'latest_weight' => $this->whenLoaded('latestWeight')
                ? new WeightResource($this->latestWeight)
                : null,
        ];
    }
}
