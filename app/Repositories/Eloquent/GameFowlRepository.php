<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\GameFowlRepositoryInterface;
use App\Models\GameFowl;
use Illuminate\Pagination\LengthAwarePaginator;

class GameFowlRepository implements GameFowlRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = GameFowl::query();

        if (isset($filters['search']) && $filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('tag_id', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['sex']) && $filters['sex']) {
            $query->where('sex', $filters['sex']);
        }

        if (isset($filters['date_hatched']) && $filters['date_hatched']) {
            $query->whereDate('date_hatched', $filters['date_hatched']);
        }

        if (isset($filters['acquisition_date']) && $filters['acquisition_date']) {
            $query->whereDate('acquisition_date', $filters['acquisition_date']);
        }

        if (isset($filters['all']) && $filters['all']) {
            return $query->latest()->get();
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id): ?GameFowl
    {
        return GameFowl::find($id);
    }

    public function create(array $data): GameFowl
    {
        return GameFowl::create($data);
    }

    public function update($id, array $data): bool
    {
        $gameFowl = GameFowl::find($id);
        if ($gameFowl) {
            return $gameFowl->update($data);
        }
        return false;
    }

    public function delete($id): bool
    {
        $gameFowl = GameFowl::find($id);
        if ($gameFowl) {
            return $gameFowl->delete();
        }
        return false;
    }
}
