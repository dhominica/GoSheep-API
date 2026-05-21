<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SheepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $latestWeight = $this->latestWeight;

        return [
            'id' => $this->id,
            'ear_tag' => $this->eartag,
            'eartag_color' => $this->eartag_color,
            'gender' => $this->gender,
            'breed' => $this->breed?->name,
            'initial_weight' => (float) $latestWeight->weight,
            'status_ui' => $this->status_ui,
        ];
    }
}
