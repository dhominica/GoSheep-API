<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightRecord extends Model
{
    protected $table = 'weight_records';

    protected $fillable = [
        'sheep_id',
        'weight',
        'recorded_by',
        'recorded_at',
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
