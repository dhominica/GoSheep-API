<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatingRecommendation extends Model
{
    use HasFactory;

    protected $table = 'mating_recommendations';

    protected $fillable = [
        'ewe_id',
        'ram_id',
        'inbreeding_coefficient',
        'ewe_ebv',
        'ram_ebv',
        'expected_ebv_offspring',
        'ahp_weights',
        'genetic_score',
        'health_score',
        'growth_score',
        'final_score',
        'is_valid',
    ];

    protected $casts = [
        'ewe_ebv' => 'array',
        'ram_ebv' => 'array',
        'expected_ebv_offspring' => 'array',
        'ahp_weights' => 'array',
        'is_valid' => 'boolean',
    ];

    public function ewe()
    {
        return $this->belongsTo(Sheep::class, 'ewe_id');
    }

    public function ram()
    {
        return $this->belongsTo(Sheep::class, 'ram_id');
    }
}
