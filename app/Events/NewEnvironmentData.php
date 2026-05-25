<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewEnvironmentData implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;
    
    public function __construct(
        public int $cageId,
        public float $temperature,
        public float $humidity,
        public string $recordedAt
    ){}
   
    public function broadcastOn(): Channel
    {
        return new PrivateChannel("cage.{$this->cageId}");
    }

    public function broadcastAs(): string
    {
        return 'environment.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'cage_id' => $this->cageId,
            'temperature' => $this->temperature,
            'humidity' => $this->humidity,
            'recorded_at' => $this->recordedAt,
        ];
    }
}
