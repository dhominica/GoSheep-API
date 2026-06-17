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
            "id"                   => $this->id,
            "mating_record_id"     => $this->mating_record_id,
            "start_date"           => $this->start_date,
            "expected_birth_date"  => $this->expected_birth_date,
            "status"               => $this->status,
            "end_date"             => $this->end_date,
            "notes"                => $this->notes,
            "ewe"                  => $this->whenLoaded('ewe') ? [
                "id"     => $this->ewe->id,
                "eartag" => $this->ewe->eartag,
            ] : null,
            "ram_eartag"           => $this->matingRecord?->ram?->eartag ?? '-',
            "birth"                => $this->whenLoaded('birth') && $this->birth
                ? [
                    "total_lambs" => $this->birth->total_lambs,
                    "birth_notes" => $this->birth->birth_notes,
                ]
                : null,
        ];
    }
}
