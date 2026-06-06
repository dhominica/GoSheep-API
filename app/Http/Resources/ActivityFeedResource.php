<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityFeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'loggable_id' => $this->loggable_id,
            'action'      => $this->action,
            'entity'      => $this->entity,
            'description' => $this->description,
            'properties'  => $this->properties,
            'user'        => $this->whenLoaded('user')
                ? [
                    'id'     => $this->user?->id,
                    'name'   => $this->user?->name,
                ] : null,
            'created_at'  => $this->created_at,
        ];
    }
}
