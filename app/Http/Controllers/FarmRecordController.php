<?php

namespace App\Http\Controllers;

use App\Services\FarmRecordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmRecordController extends Controller
{
    protected $farmRecordService;

    public function __construct(FarmRecordService $farmRecordService)
    {
        $this->farmRecordService = $farmRecordService;
    }

    public function index(Request $request)
    {
        $records = $this->farmRecordService->getAllRecords($request->all());
        return view('farm-records.index', compact('records'));
    }

    public function create()
    {
        return view('farm-records.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'record_type' => 'required|string',
            'record_date' => 'required|date',
            'related_module' => 'required|string',
            'reference_id' => 'nullable|integer',
            'description' => 'required|string',
            'quantity' => 'nullable|numeric',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $validated['recorded_by'] = Auth::id();

        $this->farmRecordService->createRecord($validated);

        return redirect()->route('staff.farm-records.index')->with('success', 'Farm record created successfully.');
    }

    public function edit($id)
    {
        $record = $this->farmRecordService->getRecordById($id);
        return view('farm-records.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'record_type' => 'required|string',
            'record_date' => 'required|date',
            'related_module' => 'required|string',
            'reference_id' => 'nullable|integer',
            'description' => 'required|string',
            'quantity' => 'nullable|numeric',
            'status' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        $this->farmRecordService->updateRecord($id, $validated);

        return redirect()->route('staff.farm-records.index')->with('success', 'Farm record updated successfully.');
    }

    public function destroy($id)
    {
        $this->farmRecordService->deleteRecord($id);
        return redirect()->route('staff.farm-records.index')->with('success', 'Farm record deleted successfully.');
    }
}
