<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEggCollectionRequest;
use App\Http\Requests\UpdateEggCollectionRequest;
use App\Services\EggCollectionService;
use App\Services\GameFowlService;
use Illuminate\Http\Request;

class EggCollectionController extends Controller
{
    protected $eggCollectionService;
    protected $gameFowlService;

    public function __construct(EggCollectionService $eggCollectionService, GameFowlService $gameFowlService)
    {
        $this->eggCollectionService = $eggCollectionService;
        $this->gameFowlService = $gameFowlService;
    }

    public function index(Request $request)
    {
        $eggCollections = $this->eggCollectionService->getAllEggCollections($request->all());
        return view('egg-collections.index', compact('eggCollections'));
    }

    public function create()
    {

        $dams = $this->gameFowlService->getAllGameFowls(['sex' => 'Female', 'all' => true]);
        $sires = $this->gameFowlService->getAllGameFowls(['sex' => 'Male', 'all' => true]);
        
        return view('egg-collections.create', compact('dams', 'sires'));
    }

    public function store(StoreEggCollectionRequest $request)
    {
        $this->eggCollectionService->createEggCollection($request->validated());
        return redirect()->route('staff.egg-collections.index')->with('success', 'Egg collection created successfully.');
    }

    public function show($id)
    {
        $eggCollection = $this->eggCollectionService->getEggCollectionById($id);
        return view('egg-collections.show', compact('eggCollection'));
    }

    public function edit($id)
    {
        $eggCollection = $this->eggCollectionService->getEggCollectionById($id);
        $dams = $this->gameFowlService->getAllGameFowls(['sex' => 'Female', 'all' => true]);
        $sires = $this->gameFowlService->getAllGameFowls(['sex' => 'Male', 'all' => true]);
        return view('egg-collections.edit', compact('eggCollection', 'dams', 'sires'));
    }

    public function update(UpdateEggCollectionRequest $request, $id)
    {
        $this->eggCollectionService->updateEggCollection($id, $request->validated());
        return redirect()->route('staff.egg-collections.index')->with('success', 'Egg collection updated successfully.');
    }

    public function destroy($id)
    {
        $this->eggCollectionService->deleteEggCollection($id);
        return redirect()->route('staff.egg-collections.index')->with('success', 'Egg collection deleted successfully.');
    }
}
