<?php

namespace App\Http\Controllers;

use App\Models\MatingRecommendation;
use Illuminate\Http\Request;

class MatingRecommendationController extends Controller
{
    /**
     * Display a listing of mating recommendations.
     */
    public function index()
    {
        // Get recommendations with related sheep models
        $recommendations = MatingRecommendation::with(['ewe', 'ram'])
            ->where('is_valid', true)
            ->orderBy('final_score', 'desc')
            ->paginate(10);

        return view('mating-recommendations.index', compact('recommendations'));
    }
}
