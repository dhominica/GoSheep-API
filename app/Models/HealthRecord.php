<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    protected $table = 'health_records';

    protected $fillable = [
        'sheep_id',
        'recorded_by',
        'category',
        'condition',
        'severity',
        'source',
        'notes',
    ];

    public function sheep()
    {
        return $this->belongsTo(Sheep::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
