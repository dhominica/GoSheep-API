<?php

namespace App\Http\Controllers;

use App\Models\HealthRecord;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
    /**
     * Display a listing of health records.
     */
    public function index(Request $request)
    {
        $query = HealthRecord::with(['sheep', 'recordedBy']);

        // Search feature
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('sheep', function ($sQuery) use ($search) {
                    $sQuery->where('eartag', 'like', "%{$search}%");
                })
                ->orWhereHas('recordedBy', function ($rQuery) use ($search) {
                    $rQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhere('condition', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $healthRecords = $query->latest('recorded_at')->paginate($perPage)->withQueryString();

        // Translate the attributes for the view
        $healthRecords->getCollection()->transform(function ($record) {
            $record->translated_category = $this->translateCategory($record->category);
            $record->translated_condition = $this->translateCondition($record->condition);
            $record->translated_severity = $this->translateSeverity($record->severity);
            $record->translated_source = $this->translateSource($record->source);
            return $record;
        });

        return view('health-records.index', compact('healthRecords'));
    }

    /**
     * Remove the specified health record from storage.
     */
    public function destroy(HealthRecord $healthRecord)
    {
        $healthRecord->delete();

        return redirect()->route('health-records.index')->with('success', 'Catatan kesehatan berhasil dihapus.');
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
    private function translateCondition($condition)
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
    private function translateSeverity($severity)
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
