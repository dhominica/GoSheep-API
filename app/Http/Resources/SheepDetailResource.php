<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SheepDetailResource extends JsonResource
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
            'ear_tag' => $this->eartag,
            'ear_tag_color' => $this->eartag_color,
            'gender' => $this->gender,
            'breed' => $this->breed?->name,
            'birth_date' => $this->birth_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'cage' => $this->cage?->name,

            'sire' => $this->whenLoaded('sire', function () {
                return [
                    'id' => $this->sire->id,
                    'ear_tag' => $this->sire->eartag,
                ];
            }),

            'dam' => $this->whenLoaded('dam', function () {
                return [
                    'id' => $this->dam->id,
                    'ear_tag' => $this->dam->eartag,
                ];
            }),

            // wajib
            'weight' => (float) ($this->latestWeight?->weight ?? 0),

            'health' => [
                'condition' => $this->latestHealth?->condition,
            ],
            'status_ui' => $this->status_ui,
        ];
    }
}
