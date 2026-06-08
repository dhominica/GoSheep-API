<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatingCheckResource extends JsonResource
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
            'mating_record_id' => $this->mating_record_id,
            'check_date' => $this->check_date,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
        ];
    }
}
