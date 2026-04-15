<?php

namespace App\Services;

use App\Models\Cage;

class CageService
{
    public function getAllCagesWithSheep()
    {
        return Cage::with('sheep')->get();
    }
}