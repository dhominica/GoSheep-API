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
        return $this->hasOne(HealthRecord::class)
            ->whereNotIn('condition', [
                'heat_stress_risk',
                'heat_stress_critical',
            ])
            ->orderByDesc('recorded_at')
            ->limit(1);
    }

    public function sire()
    {
        return $this->belongsTo(Sheep::class, 'sire_id');
    }

    public function dam()
    {
        return $this->belongsTo(Sheep::class, 'dam_id');
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

    public function pregnancies()
    {
        return $this->hasMany(Pregnancy::class, 'ewe_id');
    }

    public function currentPregnancy()
    {
        return $this->hasOne(Pregnancy::class, 'ewe_id')
            ->where('status', 'ongoing');
    }
}
