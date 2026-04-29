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
        $query = Sheep::with(['breed', 'cage']);

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
        ]);

        Sheep::create($request->all());

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
        ]);

        $sheep->update($request->all());

        return redirect()->route('sheep.index')->with('success', 'Data domba berhasil diperbarui.');
    }

    public function destroy(Sheep $sheep)
    {
        $sheep->delete();

        return redirect()->route('sheep.index')->with('success', 'Data domba berhasil dihapus.');
    }
}
