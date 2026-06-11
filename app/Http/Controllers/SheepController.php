<?php

namespace App\Http\Controllers;

use App\Models\Sheep;
use App\Models\Breed;
use App\Models\Cage;
use Illuminate\Http\Request;

class SheepController extends Controller
{
    public function index(Request $request)
    {
        $query = Sheep::with(['breed', 'cage', 'latestWeight']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('eartag', 'like', "%{$search}%")
                ->orWhere('eartag_color', 'like', "%{$search}%");
        }

        $perPage = $request->input('per_page', 10);
        $sheeps = $query->latest()->paginate($perPage)->withQueryString();

        return view('sheep.index', compact('sheeps'));
    }

    public function create()
    {
        $breeds = Breed::all();
        $cages = Cage::all();
        $sires = Sheep::where('gender', 'male')->get();
        $dams = Sheep::where('gender', 'female')->get();

        return view('sheep.create', compact('breeds', 'cages', 'sires', 'dams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'eartag' => 'required|string|unique:sheep,eartag',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'eartag_color' => 'required|string',
            'breed_id' => 'nullable|exists:breeds,id',
            'sire_id' => 'nullable|exists:sheep,id',
            'dam_id' => 'nullable|exists:sheep,id',
            'cage_id' => 'nullable|exists:cages,id',
            'status' => 'required|in:active,sold,dead',
            // New validations for initial weight and health
            'weight' => 'required|numeric|min:0.1',
            'category' => 'required|string',
            'condition' => 'required|string',
            'severity' => 'nullable|in:normal,low,medium,high',
            'notes' => 'nullable|string',
        ], [
            'eartag.required' => 'Eartag wajib diisi.',
            'eartag.unique' => 'Eartag ini sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'eartag_color.required' => 'Warna eartag wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'weight.required' => 'Berat badan awal wajib diisi.',
            'weight.numeric' => 'Berat badan harus berupa angka.',
            'weight.min' => 'Berat badan minimal 0.1 kg.',
            'category.required' => 'Kategori kesehatan wajib dipilih.',
            'condition.required' => 'Kondisi kesehatan wajib diisi.',
        ]);

        $sheep = Sheep::create($request->only([
            'eartag',
            'gender',
            'birth_date',
            'eartag_color',
            'breed_id',
            'sire_id',
            'dam_id',
            'cage_id',
            'status'
        ]));

        $sheep->weightRecords()->create([
            'weight' => $request->weight,
            'recorded_by' => \Illuminate\Support\Facades\Auth::id(),
            'recorded_at' => now(),
        ]);

        $sheep->healthRecords()->create([
            'recorded_by' => \Illuminate\Support\Facades\Auth::id(),
            'recorded_at' => now(),
            'category' => $request->category,
            'condition' => $request->condition,
            'severity' => $request->severity ?? 'normal',
            'source' => 'manual',
            'notes' => $request->notes,
        ]);

        return redirect()->route('sheep.index')->with('success', 'Data domba berhasil ditambahkan.');
    }

    public function edit(Sheep $sheep)
    {
        $breeds = Breed::all();
        $cages = Cage::all();
        $sires = Sheep::where('gender', 'male')->where('id', '!=', $sheep->id)->get();
        $dams = Sheep::where('gender', 'female')->where('id', '!=', $sheep->id)->get();

        return view('sheep.edit', compact('sheep', 'breeds', 'cages', 'sires', 'dams'));
    }

    public function update(Request $request, Sheep $sheep)
    {
        $request->validate([
            'eartag' => 'required|string|unique:sheep,eartag,' . $sheep->id,
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'eartag_color' => 'required|string',
            'breed_id' => 'nullable|exists:breeds,id',
            'sire_id' => 'nullable|exists:sheep,id',
            'dam_id' => 'nullable|exists:sheep,id',
            'cage_id' => 'nullable|exists:cages,id',
            'status' => 'required|in:active,sold,dead',
        ], [
            'eartag.required' => 'Eartag wajib diisi.',
            'eartag.unique' => 'Eartag ini sudah terdaftar.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'eartag_color.required' => 'Warna eartag wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $sheep->update($request->all());

        return redirect()->route('sheep.index')->with('success', 'Data domba berhasil diperbarui.');
    }

    public function destroy(Sheep $sheep)
    {
        $sheep->delete();

        return redirect()->route('sheep.index')->with('success', 'Data domba berhasil dihapus.');
    }

    public function exportRequest()
    {
        // Dispatch the job to the queue
        \App\Jobs\ExportSheepJob::dispatch();
        
        return redirect()->route('sheep.index')->with('success', 'Proses ekspor data domba sedang berjalan di background. Silakan tunggu beberapa saat, lalu klik "Download Hasil Ekspor".');
    }

    public function downloadExport()
    {
        $filePath = storage_path('app/public/exports/data-domba.xlsx');
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'Data_Domba_' . date('Y-m-d_H-i') . '.xlsx');
        }
        
        return redirect()->route('sheep.index')->with('error', 'File ekspor belum tersedia atau masih diproses. Silakan klik "Mulai Ekspor" terlebih dahulu.');
    }
}
