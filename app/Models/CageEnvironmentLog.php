<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CageEnvironmentLog extends Model
{
    protected $table = 'cage_environment_logs';

    protected $fillable = [
        'cage_id',
        'temperature',
        'humidity',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function cage(): BelongsTo
    {
        return $this->belongsTo(Cage::class);
    }
}
