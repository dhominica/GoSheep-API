<?php

namespace App\Services;

use App\Models\Cage;

class CageService
{
    public function getAllCagesWithSheep()
    {
        return Cage::with(['sheep' => function ($query) {
            $query->select('id', 'eartag', 'cage_id');
        }])->get();
    }
}
