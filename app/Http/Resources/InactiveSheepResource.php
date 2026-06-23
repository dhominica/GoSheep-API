<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class InactiveSheepResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $birthDate = $this->birth_date ? Carbon::parse($this->birth_date) : null;
        
        // Calculate age string (e.g. "2 th 3 bl" or "5 bl")
        if (!$birthDate) {
            $ageStr = '-';
            $birthDateStr = '-';
        } else {
            $now = Carbon::now();
            $diff = $birthDate->diff($now);
            $years = $diff->y;
            $months = $diff->m;
            
            if ($years > 0) {
                $ageStr = "{$years} th {$months} bl";
            } else {
                $ageStr = "{$months} bl";
            }

            $monthsIndo = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                7 => 'Jul', 8 => 'Ags', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];
            
            $birthDateStr = "{$birthDate->day} {$monthsIndo[$birthDate->month]} {$birthDate->year}";
        }

        return [
            'id' => $this->id,
            'ear_tag' => $this->eartag,
            'gender' => $this->gender === 'male' ? 'Jantan' : 'Betina',
            'breed' => $this->breed?->name ?? '-',
            'cage' => $this->cage?->name ?? '-',
            'weight_kg' => (float) ($this->latestWeight?->weight ?? 0.0),
            'age' => $ageStr,
            'birth_date' => $birthDateStr,
            'status' => $this->status,
        ];
    }
}
