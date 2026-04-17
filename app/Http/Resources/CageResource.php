<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CageResource extends JsonResource
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
            'name' => $this->name,
            'current_capacity' => $this->current_capacity,
            'max_capacity' => $this->max_capacity,
            'status_label' => match (true) {
                $this->current_capacity == 0 => 'Kosong',
                $this->current_capacity >= $this->max_capacity => 'Penuh',
                default => 'Terisi',
            },
            'created_at' => $this->created_at,

            'sheep' => $this->sheep->map(function ($sheep) {
                return [
                    'id' => $sheep->id,
                    'eartag' => $sheep->eartag,
                ];
            }),
        ];
    }
}
