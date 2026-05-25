<?php

namespace App\Http\Controllers;

use App\Models\Sheep;
use App\Models\WeightRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeightRecordController extends Controller
{
    /**
     * Display a listing of the sheep for weight recording.
     */
    public function index()
    {
        // Get all active sheep, with their latest weight and breed for the cards
        $sheeps = Sheep::with(['latestWeight', 'breed'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('berat.index', compact('sheeps'));
    }

    /**
     * Show the form for creating a new weight record and display weight history chart.
     */
    public function show(Sheep $sheep)
    {
        // Load all weight records for this sheep, ordered by date ascending for the chart
        $weightHistory = $sheep->weightRecords()
            ->with('recordedBy')
            ->orderBy('recorded_at', 'asc')
            ->get();

        return view('berat.show', compact('sheep', 'weightHistory'));
    }

    /**
     * Store a newly created weight record in storage.
     */
    public function store(Request $request, Sheep $sheep)
    {
        $request->validate([
            'weight' => 'required|numeric|min:0.1|max:500',
        ]);

        WeightRecord::create([
            'sheep_id' => $sheep->id,
            'weight' => $request->weight,
            'recorded_by' => Auth::id(),
            'recorded_at' => now(),
        ]);

        return redirect()->route('berat.show', $sheep->id)
            ->with('success', 'Berat badan berhasil ditambahkan!');
    }
}
