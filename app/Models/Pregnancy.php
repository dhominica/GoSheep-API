<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregnancy extends Model
{
    protected $fillable = [
        'mating_record_id',
        'ewe_id',
        'start_date',
        'expected_birth_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_birth_date' => 'date',
        'end_date' => 'date',
    ];

    public function matingRecord()
    {
        return $this->belongsTo(MatingRecord::class);
    }

    public function ewe()
    {
        return $this->belongsTo(Sheep::class, 'ewe_id');
    }
}
