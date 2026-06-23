<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SheepFeature extends Model
{
    protected $table = 'sheep_features';

    protected $fillable = [
        'sheep_id',
        'weight_birth',
        'weight_weaning',
        'weight_180d',
        'weight_365d',
        'ADG_0_90',
        'ADG_90_180',
        'health_score',
        'EBV_Bobot',
        'EBV_ADG',
        'EBV_Kesehatan',
        'computed_at',
    ];

    protected $casts = [
        'weight_birth'   => 'float',
        'weight_weaning' => 'float',
        'weight_180d'    => 'float',
        'weight_365d'    => 'float',
        'ADG_0_90'       => 'float',
        'ADG_90_180'     => 'float',
        'health_score'   => 'float',
        'EBV_Bobot'      => 'float',
        'EBV_ADG'        => 'float',
        'EBV_Kesehatan'  => 'float',
        'computed_at'    => 'datetime',
    ];

    public function sheep()
    {
        return $this->belongsTo(Sheep::class);
    }

    public function isReadyForPrediction(): bool
    {
        return $this->weight_birth   !== null
            && $this->weight_weaning !== null
            && $this->ADG_0_90       !== null
            && $this->health_score   !== null;
    }

    public function hasEBV(): bool
    {
        return $this->EBV_Bobot     !== null
            && $this->EBV_ADG       !== null
            && $this->EBV_Kesehatan !== null;
    }
}
