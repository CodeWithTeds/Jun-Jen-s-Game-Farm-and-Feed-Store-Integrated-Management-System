<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHatcheryRecordRequest;
use App\Http\Requests\UpdateHatcheryRecordRequest;
use App\Services\HatcheryRecordService;
use App\Services\EggCollectionService;
use Illuminate\Http\Request;

class HatcheryRecordController extends Controller
{
    protected $hatcheryRecordService;
    protected $eggCollectionService;

    public function __construct(HatcheryRecordService $hatcheryRecordService, EggCollectionService $eggCollectionService)
    {
        $this->hatcheryRecordService = $hatcheryRecordService;
        $this->eggCollectionService = $eggCollectionService;
    }

    public function index(Request $request)
    {
        $hatcheryRecords = $this->hatcheryRecordService->getAllHatcheryRecords($request->all());
        return view('hatchery-records.index', compact('hatcheryRecords'));
    }

    public function create()
    {
        $eggCollections = $this->eggCollectionService->getAllEggCollections();
        return view('hatchery-records.create', compact('eggCollections'));
    }

    public function store(StoreHatcheryRecordRequest $request)
    {
        $this->hatcheryRecordService->createHatcheryRecord($request->validated());
        return redirect()->route('staff.hatchery-records.index')->with('success', 'Hatchery record created successfully.');
    }

    public function show($id)
    {
        $hatcheryRecord = $this->hatcheryRecordService->getHatcheryRecordById($id);
        return view('hatchery-records.show', compact('hatcheryRecord'));
    }

    public function edit($id)
    {
        $hatcheryRecord = $this->hatcheryRecordService->getHatcheryRecordById($id);
        $eggCollections = $this->eggCollectionService->getAllEggCollections();
        return view('hatchery-records.edit', compact('hatcheryRecord', 'eggCollections'));
    }

    public function update(UpdateHatcheryRecordRequest $request, $id)
    {
        $this->hatcheryRecordService->updateHatcheryRecord($id, $request->validated());
        return redirect()->route('staff.hatchery-records.index')->with('success', 'Hatchery record updated successfully.');
    }

    public function destroy($id)
    {
        $this->hatcheryRecordService->deleteHatcheryRecord($id);
        return redirect()->route('staff.hatchery-records.index')->with('success', 'Hatchery record deleted successfully.');
    }
}
