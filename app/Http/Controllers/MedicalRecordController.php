<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\GameFowl;
use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MedicalRecord::with('gameFowl');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                  ->orWhere('medication_name', 'like', "%{$search}%")
                  ->orWhereHas('gameFowl', function($q) use ($search) {
                      $q->where('tag_id', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $medicalRecords = $query->latest('date')->paginate(10);

        return view('medical-records.index', compact('medicalRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $gameFowlId = $request->query('game_fowl_id');
        $gameFowls = GameFowl::orderBy('tag_id')->get();
        $selectedGameFowl = $gameFowlId ? GameFowl::find($gameFowlId) : null;

        return view('medical-records.create', compact('gameFowls', 'selectedGameFowl'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalRecordRequest $request)
    {
        MedicalRecord::create($request->validated());

        return redirect()->route('staff.medical-records.index')
            ->with('success', 'Medical record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('gameFowl');
        return view('medical-records.show', compact('medicalRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $gameFowls = GameFowl::orderBy('tag_id')->get();
        return view('medical-records.edit', compact('medicalRecord', 'gameFowls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->update($request->validated());

        return redirect()->route('staff.medical-records.index')
            ->with('success', 'Medical record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('staff.medical-records.index')
            ->with('success', 'Medical record deleted successfully.');
    }
}
