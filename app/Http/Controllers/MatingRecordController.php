<?php

namespace App\Http\Controllers;

use App\Models\MatingRecord;
use App\Models\Sheep;
use App\Models\Pregnancy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MatingRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matingRecords = MatingRecord::with(['ewe', 'ram'])->orderBy('mating_date', 'desc')->paginate(10);
        return view('mating.index', compact('matingRecords'));
    }

    /**
     * Store a newly created resource in storage (from recommendation).
     */
    public function store(Request $request)
    {
        $request->validate([
            'ewe_id' => 'required|exists:sheep,id',
            'ram_id' => 'required|exists:sheep,id',
            'recommendation_id' => 'nullable|exists:mating_recommendations,id',
            'mating_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:mating_date',
        ]);

        MatingRecord::create([
            'ewe_id' => $request->ewe_id,
            'ram_id' => $request->ram_id,
            'recomendation_id' => $request->recommendation_id, // Note typo in model fillable
            'mating_date' => $request->mating_date,
            'end_date' => $request->end_date,
            'result' => 'unknown',
        ]);

        return redirect()->route('mating.index')->with('success', 'Data persilangan berhasil ditambahkan dari rekomendasi');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatingRecord $mating)
    {
        $ewes = Sheep::where('gender', 'female')->where('status', 'active')->get();
        $rams = Sheep::where('gender', 'male')->where('status', 'active')->get();
        return view('mating.edit', compact('mating', 'ewes', 'rams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MatingRecord $mating)
    {
        $request->validate([
            'ewe_id' => 'required|exists:sheep,id',
            'ram_id' => 'required|exists:sheep,id',
            'mating_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:mating_date',
            'result' => 'nullable|in:pregnant,not_pregnant,failed,unknown',
            'expected_birth_date' => 'nullable|required_if:result,pregnant|date|after_or_equal:mating_date',
        ]);

        $oldResult = $mating->result;
        $newResult = $request->input('result');

        // Check if pregnancy exists and is finished
        $oldPregnancy = Pregnancy::where('mating_record_id', $mating->id)->first();
        if ($oldPregnancy && in_array($oldPregnancy->status, ['birthed', 'miscarried'])) {
            throw ValidationException::withMessages([
                'result' => 'Data persilangan tidak dapat diubah karena status kehamilan sudah selesai (lahir atau keguguran)'
            ]);
        }

        $mating->update($request->all());

        if ($oldResult === 'pregnant' && $newResult !== 'pregnant') {
            Pregnancy::where('mating_record_id', $mating->id)->delete();
        } elseif ($newResult === 'pregnant') {
            Pregnancy::updateOrCreate(
                ['mating_record_id' => $mating->id],
                [
                    'ewe_id' => $mating->ewe_id,
                    'start_date' => $mating->mating_date,
                    'expected_birth_date' => $request->input('expected_birth_date'),
                    'status' => 'ongoing',
                ]
            );
        }

        return redirect()->route('mating.index')->with('success', 'Data persilangan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatingRecord $mating)
    {
        $mating->delete();
        return redirect()->route('mating.index')->with('success', 'Data persilangan berhasil dihapus');
    }
}
