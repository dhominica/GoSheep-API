<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Birth extends Model
{
    protected $fillable = [
        'pregnancy_id',
        'total_lambs',
        'birth_notes',
    ];

    public function pregnancy()
    {
        return $this->belongsTo(Pregnancy::class);
    }
}
