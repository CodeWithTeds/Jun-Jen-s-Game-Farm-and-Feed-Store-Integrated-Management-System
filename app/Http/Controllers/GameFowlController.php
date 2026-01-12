<?php

namespace App\Http\Controllers;

use App\Models\GameFowl;
use Illuminate\Http\Request;
use App\Services\GameFowlService;
use App\Http\Requests\StoreGameFowlRequest;
use App\Http\Requests\UpdateGameFowlRequest;

class GameFowlController extends Controller
{


    public function __construct(protected GameFowlService $gameFowlService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gameFowls = $this->gameFowlService->getAllGameFowls($request->all());
        return view('game-fowls.index', compact('gameFowls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sires = GameFowl::where('sex', 'Male')->orderBy('name')->get();
        $dams = GameFowl::where('sex', 'Female')->orderBy('name')->get();
        return view('game-fowls.create', compact('sires', 'dams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameFowlRequest $request)
    {
        $this->gameFowlService->createGameFowl($request->validated());

        return redirect()->route('staff.game-fowls.index')
            ->with('success', 'Game Fowl record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GameFowl $gameFowl)
    {
        $gameFowl->load('medicalRecords');
        return view('game-fowls.show', compact('gameFowl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameFowl $gameFowl)
    {
        $sires = GameFowl::where('sex', 'Male')->where('id', '!=', $gameFowl->id)->orderBy('name')->get();
        $dams = GameFowl::where('sex', 'Female')->where('id', '!=', $gameFowl->id)->orderBy('name')->get();
        return view('game-fowls.edit', compact('gameFowl', 'sires', 'dams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameFowlRequest $request, GameFowl $gameFowl)
    {
        $this->gameFowlService->updateGameFowl($gameFowl->id, $request->validated());

        return redirect()->route('staff.game-fowls.index')
            ->with('success', 'Game Fowl record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameFowl $gameFowl)
    {
        $this->gameFowlService->deleteGameFowl($gameFowl->id);

        return redirect()->route('staff.game-fowls.index')
            ->with('success', 'Game Fowl record deleted successfully.');
    }
}
