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
            'nama_kandang' => $this->name,
            'kapasitas_maksimal' => $this->max_capacity,
            'jumlah_terisi' => $this->current_capacity,
            'status_label' => $this->current_capacity > 0 ? 'Terisi' : 'Kosong',
            
            'domba_didalam' => $this->sheep->map(function ($sheep) {
                return [
                    'id_domba' => $sheep->id,
                    'eartag' => $sheep->eartag,
                ];
            }),
        ];
    }
}
