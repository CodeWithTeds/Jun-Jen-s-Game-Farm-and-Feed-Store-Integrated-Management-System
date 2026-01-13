<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\HatcheryRecordRepositoryInterface;
use App\Models\HatcheryRecord;
use Illuminate\Pagination\LengthAwarePaginator;

class HatcheryRecordRepository implements HatcheryRecordRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = HatcheryRecord::query()->with('eggCollection');

        return $query->latest()->paginate($perPage);
    }

    public function getById($id): ?HatcheryRecord
    {
        return HatcheryRecord::with('eggCollection')->find($id);
    }

    public function create(array $data): HatcheryRecord
    {
        return HatcheryRecord::create($data);
    }

    public function update($id, array $data): bool
    {
        $record = HatcheryRecord::find($id);
        if ($record) {
            return $record->update($data);
        }
        return false;
    }

    public function delete($id): bool
    {
        $record = HatcheryRecord::find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    public function getByEggCollectionId($eggCollectionId): ?HatcheryRecord
    {
        return HatcheryRecord::where('egg_collection_id', $eggCollectionId)->first();
    }
}
