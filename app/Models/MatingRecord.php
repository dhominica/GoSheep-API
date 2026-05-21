<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MatingCheck;
class MatingRecord extends Model
{
    use HasFactory;

    protected $table = 'mating_records';

    protected $fillable = [
        'ewe_id',
        'ram_id',
        'recomendation_id',
        'mating_date',
        'end_date',
        'actual_result_date',
        'result',
    ];

    public function ewe()
    {
        return $this->belongsTo(Sheep::class, 'ewe_id');
    }

    public function ram()
    {
        return $this->belongsTo(Sheep::class, 'ram_id');
    }

    public function checks()
    {
        return $this->hasMany(MatingCheck::class, 'mating_record_id');
    }
}
