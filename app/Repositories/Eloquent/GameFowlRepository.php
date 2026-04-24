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

        if (isset($filters['classification']) && $filters['classification']) {
            $query->where('classification', $filters['classification']);
        }

        if (isset($filters['conditioning_status']) && $filters['conditioning_status']) {
            $query->where('conditioning_status', $filters['conditioning_status']);
        }

        if (isset($filters['reproductive_status']) && $filters['reproductive_status']) {
            $query->where('reproductive_status', $filters['reproductive_status']);
        }

        if (isset($filters['gender_identification']) && $filters['gender_identification']) {
            $query->where('gender_identification', $filters['gender_identification']);
        }

        if (isset($filters['initial_health_status']) && $filters['initial_health_status']) {
            $query->where('initial_health_status', $filters['initial_health_status']);
        }

        if (isset($filters['date_hatched']) && $filters['date_hatched']) {
            $query->whereDate('date_hatched', $filters['date_hatched']);
        }

        if (isset($filters['exclude_sold']) && $filters['exclude_sold']) {
            $query->where(function ($q) {
                $q->whereNull('sale_status')
                    ->orWhere('sale_status', '!=', 'Sold');
            });
        }

        if (isset($filters['exclude_dead']) && $filters['exclude_dead']) {
            $query->where('initial_health_status', '!=', 'Dead');
        }

        if (isset($filters['acquisition_date']) && $filters['acquisition_date']) {
            $query->whereDate('acquisition_date', $filters['acquisition_date']);
        }

        if (isset($filters['fit_to_fight']) && $filters['fit_to_fight']) {
            $query->fitToFight();
        }

        if (isset($filters['without_active_fight_schedule']) && $filters['without_active_fight_schedule']) {
            $query->whereDoesntHave('fightSchedules', function ($fightScheduleQuery) {
                $fightScheduleQuery->where('status', 'Scheduled');
            });
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
