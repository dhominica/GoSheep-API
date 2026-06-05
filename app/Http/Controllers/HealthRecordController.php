<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
    /**
     * Display a listing of the sheep for health recording.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Sheep::with(['latestHealth', 'breed'])
            ->where('status', 'active');
            
        if ($request->filled('search')) {
            $query->where('eartag', 'like', '%' . $request->search . '%');
        }

        // Get all active sheep, with their latest health and breed for the cards
        $sheeps = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Translate the attributes for the view
        $sheeps->getCollection()->transform(function ($sheep) {
            if ($sheep->latestHealth) {
                $sheep->latestHealth->translated_condition = $this->translateCondition($sheep->latestHealth->condition);
                $sheep->latestHealth->translated_severity = $this->translateSeverity($sheep->latestHealth->severity);
            }
            return $sheep;
        });

        return view('health-records.index', compact('sheeps'));
    }

    /**
     * Show the form for creating a new health record and display health history.
     */
    public function show(\App\Models\Sheep $sheep)
    {
        // Load all health records for this sheep, ordered by date descending
        $healthHistory = $sheep->healthRecords()
            ->with('recordedBy')
            ->orderBy('recorded_at', 'desc')
            ->get();

        $healthHistory->transform(function ($record) {
            $record->translated_category = $this->translateCategory($record->category);
            $record->translated_condition = $this->translateCondition($record->condition);
            $record->translated_severity = $this->translateSeverity($record->severity);
            $record->translated_source = $this->translateSource($record->source);
            return $record;
        });

        return view('health-records.show', compact('sheep', 'healthHistory'));
    }

    /**
     * Store a newly created health record in storage.
     */
    public function store(Request $request, \App\Models\Sheep $sheep)
    {
        $request->validate([
            'category' => 'required|string',
            'condition' => 'required|string',
            'severity' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        HealthRecord::create([
            'sheep_id' => $sheep->id,
            'category' => $request->category,
            'condition' => $request->condition,
            'severity' => $request->severity,
            'source' => 'manual',
            'notes' => $request->notes,
            'recorded_by' => \Illuminate\Support\Facades\Auth::id(),
            'recorded_at' => now(),
        ]);

        return redirect()->route('health-records.show', $sheep->id)
            ->with('success', 'Catatan kesehatan berhasil ditambahkan!');
    }

    /**
     * Remove the specified health record from storage.
     */
    public function destroy(HealthRecord $healthRecord)
    {
        $sheepId = $healthRecord->sheep_id;
        $healthRecord->delete();

        return redirect()->route('health-records.show', $sheepId)->with('success', 'Catatan kesehatan berhasil dihapus.');
    }

    /**
     * Translate Category to Indonesian.
     */
    private function translateCategory($category)
    {
        $map = [
            'health' => 'Kesehatan',
            'nutrition' => 'Nutrisi',
            'environment' => 'Lingkungan',
            'maintenance' => 'Pemeliharaan',
        ];

        return $map[strtolower($category)] ?? ucfirst($category);
    }

    /**
     * Translate Condition to Indonesian.
     */
    public function translateCondition($condition)
    {
        $map = [
            'heat_stress_risk' => 'Risiko Stres Panas',
            'pregnant' => 'Bunting',
            'sick' => 'Sakit',
            'injured' => 'Cedera',
            'healthy' => 'Sehat',
            'vaccinated' => 'Divaksin',
            'low_appetite' => 'Nafsu Makan Rendah',
            'normal_feed_intake' => 'Porsi Makan Normal',
        ];

        return $map[strtolower($condition)] ?? ucwords(str_replace('_', ' ', $condition));
    }

    /**
     * Translate Severity to Indonesian.
     */
    public function translateSeverity($severity)
    {
        $map = [
            'normal' => 'Normal',
            'ringan' => 'Ringan',
            'sedang' => 'Sedang',
            'berat' => 'Berat',
            'warning' => 'Peringatan',
            'critical' => 'Kritis',
        ];

        return $map[strtolower($severity)] ?? ucfirst($severity);
    }

    /**
     * Translate Source to Indonesian.
     */
    private function translateSource($source)
    {
        $map = [
            'manual' => 'Manual',
            'iot' => 'IoT',
        ];

        return $map[strtolower($source)] ?? strtoupper($source);
    }
}
