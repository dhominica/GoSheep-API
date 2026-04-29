<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use Illuminate\Http\Request;

class CageController extends Controller
{
    public function index(Request $request)
    {
        $query = Cage::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $perPage = $request->input('per_page', 10);
        $cages = $query->withCount('sheep')->latest()->paginate($perPage)->withQueryString();

        return view('cage.index', compact('cages'));
    }

    public function create()
    {
        return view('cage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cages,name',
            'current_capacity' => 'required|integer|min:0',
            'max_capacity' => 'required|integer|min:1|gte:current_capacity',
        ]);

        Cage::create($request->all());

        return redirect()->route('cage.index')->with('success', 'Kandang berhasil ditambahkan.');
    }

    public function edit(Cage $cage)
    {
        return view('cage.edit', compact('cage'));
    }

    public function update(Request $request, Cage $cage)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cages,name,' . $cage->id,
            'current_capacity' => 'required|integer|min:0',
            'max_capacity' => 'required|integer|min:1|gte:current_capacity',
        ]);

        $cage->update($request->all());

        return redirect()->route('cage.index')->with('success', 'Data kandang berhasil diperbarui.');
    }

    public function destroy(Cage $cage)
    {
        // Prevent deleting if there are sheep in it
        if ($cage->sheep()->count() > 0) {
            return redirect()->route('cage.index')->with('error', 'Kandang tidak dapat dihapus karena masih berisi domba.');
        }

        $cage->delete();

        return redirect()->route('cage.index')->with('success', 'Kandang berhasil dihapus.');
    }
}
