<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\EggCollectionRepositoryInterface;
use App\Models\EggCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class EggCollectionRepository implements EggCollectionRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = EggCollection::query()->with(['dam', 'sire', 'hatcheryRecord']);

        if (isset($filters['search']) && $filters['search']) {
            // Add search logic if needed
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id): ?EggCollection
    {
        return EggCollection::with(['dam', 'sire', 'hatcheryRecord'])->find($id);
    }

    public function create(array $data): EggCollection
    {
        return EggCollection::create($data);
    }

    public function update($id, array $data): bool
    {
        $record = EggCollection::find($id);
        if ($record) {
            return $record->update($data);
        }
        return false;
    }

    public function delete($id): bool
    {
        $record = EggCollection::find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
}
