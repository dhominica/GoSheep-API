<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PregnanciesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "start_date" => $this->start_date,
            "expected_birth_date" => $this->expected_birth_date,
            "status" => $this->status,
            "ewe" => $this->whenLoaded('ewe') ?
            [
                "id" => $this->ewe->id,
                "eartag" => $this->ewe->eartag,
            ] : null,
        ];
    }
}
