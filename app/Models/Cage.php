<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cage extends Model
{
    protected $table = 'cages';

    protected $fillable = [
        'name',
        'current_capacity',
        'max_capacity',
    ];

    public function sheep()
    {
        return $this->hasMany(Sheep::class);
    }

    public function environmentLogs(): HasMany
    {
        return $this->hasMany(CageEnvironmentLog::class);
    }
}
