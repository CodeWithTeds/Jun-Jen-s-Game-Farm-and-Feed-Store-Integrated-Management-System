<?php

namespace App\Http\Controllers;

use App\Models\Breeding;
use App\Models\GameFowl;
use Illuminate\Http\Request;

class BreedingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breedings = Breeding::with(['sire', 'dam'])->latest()->paginate(10);
        return view('breedings.index', compact('breedings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sires = GameFowl::where('sex', 'Male')->orderBy('name')->get();
        $dams = GameFowl::where('sex', 'Female')->orderBy('name')->get();
        return view('breedings.create', compact('sires', 'dams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sire_id' => 'required|exists:game_fowls,id',
            'dam_id' => 'required|exists:game_fowls,id',
            'breeding_date' => 'required|date',
            'type' => 'required|string',
            'pen_number' => 'required|string',
            'expected_hatch_date' => 'nullable|date',
            'clutch_number' => 'nullable|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Breeding::create($validated);

        return redirect()->route('staff.breedings.index')
            ->with('success', 'Breeding record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Breeding $breeding)
    {
        $breeding->load(['sire', 'dam']);
        return view('breedings.show', compact('breeding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Breeding $breeding)
    {
        $sires = GameFowl::where('sex', 'Male')->orderBy('name')->get();
        $dams = GameFowl::where('sex', 'Female')->orderBy('name')->get();
        return view('breedings.edit', compact('breeding', 'sires', 'dams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Breeding $breeding)
    {
        $validated = $request->validate([
            'sire_id' => 'required|exists:game_fowls,id',
            'dam_id' => 'required|exists:game_fowls,id',
            'breeding_date' => 'required|date',
            'type' => 'required|string',
            'pen_number' => 'required|string',
            'expected_hatch_date' => 'nullable|date',
            'clutch_number' => 'nullable|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $breeding->update($validated);

        return redirect()->route('staff.breedings.index')
            ->with('success', 'Breeding record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Breeding $breeding)
    {
        $breeding->delete();

        return redirect()->route('staff.breedings.index')
            ->with('success', 'Breeding record deleted successfully.');
    }
}
