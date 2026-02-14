<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\GameFowlInventoryRepositoryInterface;
use App\Repositories\Contracts\GameFowlRepositoryInterface;
use Illuminate\Http\Request;

class GameFowlInventoryController extends Controller
{
    protected $inventoryRepository;
    protected $gameFowlRepository;

    public function __construct(
        GameFowlInventoryRepositoryInterface $inventoryRepository,
        GameFowlRepositoryInterface $gameFowlRepository
    ) {
        $this->inventoryRepository = $inventoryRepository;
        $this->gameFowlRepository = $gameFowlRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'sex', 'reproductive_status', 'gender_identification']);
        $inventories = $this->inventoryRepository->getAll($filters);
        $gameFowlFilters = array_merge($filters, ['all' => true]);
        $gameFowls = $this->gameFowlRepository->getAll($gameFowlFilters);
        return view('game_fowl_inventory.index', compact('inventories', 'gameFowls'));
    }

    public function create()
    {
        $gameFowls = $this->gameFowlRepository->getAll(['all' => true]);
        return view('game_fowl_inventory.create', compact('gameFowls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_fowl_id' => 'required|exists:game_fowls,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $this->inventoryRepository->create($request->all());

        return redirect()->route('staff.game-fowl-inventory.index')
            ->with('success', 'Inventory added successfully.');
    }

    public function edit($id)
    {
        $inventory = $this->inventoryRepository->findById($id);
        $gameFowls = $this->gameFowlRepository->getAll(['all' => true]);
        return view('game_fowl_inventory.edit', compact('inventory', 'gameFowls'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'game_fowl_id' => 'required|exists:game_fowls,id',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $this->inventoryRepository->update($id, $request->all());

        return redirect()->route('staff.game-fowl-inventory.index')
            ->with('success', 'Inventory updated successfully.');
    }

    public function destroy($id)
    {
        $this->inventoryRepository->delete($id);

        return redirect()->route('staff.game-fowl-inventory.index')
            ->with('success', 'Inventory deleted successfully.');
    }
}
