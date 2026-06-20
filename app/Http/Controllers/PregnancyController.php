<?php

namespace App\Http\Controllers;

use App\Models\Birth;
use App\Models\Pregnancy;
use Illuminate\Http\Request;

class PregnancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pregnancies = Pregnancy::with(['ewe', 'matingRecord.ram', 'birth'])->orderBy('id', 'desc')->paginate(10);
        return view('pregnancies.index', compact('pregnancies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pregnancy $pregnancy)
    {
        $pregnancy->load(['ewe', 'matingRecord.ram', 'birth']);
        return view('pregnancies.edit', compact('pregnancy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pregnancy $pregnancy)
    {
        $request->validate([
            'expected_birth_date' => 'nullable|date',
            'status'              => 'required|in:ongoing,birthed,miscarried',
            'end_date'            => 'nullable|date',
            'notes'               => 'nullable|string',
            'total_lambs'         => 'required_if:status,birthed|nullable|integer|min:1',
            'birth_notes'         => 'nullable|string|max:500',
        ]);

        $oldStatus = $pregnancy->status;
        $newStatus = $request->input('status');

        $pregnancy->update([
            'expected_birth_date' => $request->input('expected_birth_date'),
            'status'              => $newStatus,
            'end_date'            => in_array($newStatus, ['birthed', 'miscarried'])
                                     ? ($request->input('end_date') ?? now()->toDateString())
                                     : null,
            'notes'               => $request->input('notes'),
        ]);

        // --- Sync births table ---
        if ($newStatus === 'birthed') {
            Birth::updateOrCreate(
                ['pregnancy_id' => $pregnancy->id],
                [
                    'total_lambs' => $request->input('total_lambs'),
                    'birth_notes' => $request->input('birth_notes'),
                ]
            );
        } elseif ($oldStatus === 'birthed' && $newStatus !== 'birthed') {
            Birth::where('pregnancy_id', $pregnancy->id)->delete();
        }

        return redirect()->route('pregnancies.index')->with('success', 'Data kehamilan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pregnancy $pregnancy)
    {
        $pregnancy->delete();
        return redirect()->route('pregnancies.index')->with('success', 'Data kehamilan berhasil dihapus');
    }
}
