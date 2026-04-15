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
        $latestWeight = $this->latestWeight();

        $latestHealth = $this->latestHealth();

        $statusUi = 'sehat';

        if ($latestHealth) {
            if ($latestHealth->severity === 'warning') {
                $statusUi = 'at_risk';
            } elseif ($latestHealth->severity === 'critical') {
                $statusUi = 'sakit';
            }
        }

        return [
            'id' => $this->id,
            'earTag' => $this->eartag,
            'gender' => $this->gender,
            'breed' => $this->breed->name ?? null,

            'weight' => $latestWeight->weight,

            'status_ui' => $statusUi,
        ];
    }
}
