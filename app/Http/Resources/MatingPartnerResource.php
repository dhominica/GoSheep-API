<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatingPartnerResource extends JsonResource
{
    protected int $sheepId;

    public function __construct($resource, int $sheepId)
    {
        parent::__construct($resource);
        $this->sheepId = $sheepId;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isEwe = $this->ewe_id === $this->sheepId;
        $partner = $isEwe ? $this->ram : $this->ewe;

        return [
            'id' => $partner ? $partner->id : null,
            'eartag' => $partner ? $partner->eartag : null,
            'mating_record_id' => $this->id,
        ];
    }
}
