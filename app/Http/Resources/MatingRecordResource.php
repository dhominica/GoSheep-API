<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatingRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $latestCheck = $this->checks->first();
        $tanggalSelesai = $latestCheck ? $latestCheck->check_date : '-';

        return [
            'id' => $this->id,
            'ewe_id' => $this->ewe_id,
            'ram_id' => $this->ram_id,
            'ewe_ear_tag' => $this->ewe ? $this->ewe->eartag : null,
            'ram_ear_tag' => $this->ram ? $this->ram->eartag : null,
            'mating_date' => $this->mating_date,
            'end_date' => $this->end_date ?? null,
            'result' => $this->result,
        ];
    }
}
