<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sheep extends Model
{
    protected $table = 'sheep';

    protected $fillable = [
        'eartag',
        'gender',
        'birth_date',
        'eartag_color',
        'breed_id',
        'sire_id',
        'dam_id',
        'cage_id',
        'status',
    ];

    public function latestWeight()
    {
        return $this->hasOne(WeightRecord::class)->latestOfMany('created_at');
    }

    public function latestHealth()
    {
        return $this->hasOne(HealthRecord::class)->latestOfMany('created_at');
    }

    public function weightRecords()
    {
        return $this->hasMany(WeightRecord::class);
    }

    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function cage()
    {
        return $this->belongsTo(Cage::class);
    }
}
