<?php

namespace App\Http\Controllers;

use App\Models\ChickRearing;
use Illuminate\Http\Request;
use App\Services\ChickRearingService;
use App\Http\Requests\StoreChickRearingRequest;
use App\Http\Requests\UpdateChickRearingRequest;

class ChickRearingController extends Controller
{
    public function __construct(protected ChickRearingService $chickRearingService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chickRearings = $this->chickRearingService->getAllChickRearings($request->all());
        return view('chick-rearings.index', compact('chickRearings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chick-rearings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChickRearingRequest $request)
    {
        $this->chickRearingService->createChickRearing($request->validated());

        return redirect()->route('staff.chick-rearings.index')
            ->with('success', 'Chick Rearing record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChickRearing $chickRearing)
    {
        return view('chick-rearings.show', compact('chickRearing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChickRearing $chickRearing)
    {
        return view('chick-rearings.edit', compact('chickRearing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChickRearingRequest $request, ChickRearing $chickRearing)
    {
        $this->chickRearingService->updateChickRearing($chickRearing->id, $request->validated());

        return redirect()->route('staff.chick-rearings.index')
            ->with('success', 'Chick Rearing record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChickRearing $chickRearing)
    {
        $this->chickRearingService->deleteChickRearing($chickRearing->id);

        return redirect()->route('staff.chick-rearings.index')
            ->with('success', 'Chick Rearing record deleted successfully.');
    }
}
