<?php

namespace App\Repositories\Eloquent;

use App\Models\GameFowlInventory;
use App\Repositories\Contracts\GameFowlInventoryRepositoryInterface;

class GameFowlInventoryRepository implements GameFowlInventoryRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = GameFowlInventory::with('gameFowl');

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['sex']) && $filters['sex']) {
            $query->whereHas('gameFowl', function ($q) use ($filters) {
                $q->where('sex', $filters['sex']);
            });
        }

        if (isset($filters['reproductive_status']) && $filters['reproductive_status']) {
            $query->whereHas('gameFowl', function ($q) use ($filters) {
                $q->where('reproductive_status', $filters['reproductive_status']);
            });
        }

        if (isset($filters['gender_identification']) && $filters['gender_identification']) {
            $query->whereHas('gameFowl', function ($q) use ($filters) {
                $q->where('gender_identification', $filters['gender_identification']);
            });
        }

        if (isset($filters['all']) && $filters['all']) {
            return $query->orderBy('created_at', 'desc')->get();
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById($id)
    {
        return GameFowlInventory::findOrFail($id);
    }

    public function create(array $data)
    {
        return GameFowlInventory::create($data);
    }

    public function update($id, array $data)
    {
        $inventory = $this->findById($id);
        $inventory->update($data);
        return $inventory;
    }

    public function delete($id)
    {
        $inventory = $this->findById($id);
        return $inventory->delete();
    }

    public function getByGameFowlId($gameFowlId)
    {
        return GameFowlInventory::where('game_fowl_id', $gameFowlId)->orderBy('created_at', 'desc')->get();
    }

    public function markAsDeceasedByGameFowlId(int $gameFowlId)
    {
        return GameFowlInventory::where('game_fowl_id', $gameFowlId)->update([
            'quantity' => 0,
            'status' => 'Deceased',
        ]);
    }
}
