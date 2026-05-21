<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatingCheck extends Model
{
    use HasFactory;

    protected $table = 'mating_checks';

    protected $fillable = [
        'mating_record_id',
        'check_date',
        'notes',
    ];

    public function matingRecord()
    {
        return $this->belongsTo(MatingRecord::class, 'mating_record_id');
    }
}
