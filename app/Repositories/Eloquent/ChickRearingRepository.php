<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ChickRearingRepositoryInterface;
use App\Models\ChickRearing;

class ChickRearingRepository implements ChickRearingRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10)
    {
        $query = ChickRearing::query();

        if (isset($filters['search']) && $filters['search']) {
            $query->where('chick_tag_id', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('remarks', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['growth_stage']) && $filters['growth_stage']) {
            $query->where('growth_stage', $filters['growth_stage']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id)
    {
        return ChickRearing::find($id);
    }

    public function create(array $data)
    {
        return ChickRearing::create($data);
    }

    public function update($id, array $data)
    {
        $chickRearing = ChickRearing::find($id);
        if ($chickRearing) {
            $chickRearing->update($data);
            return $chickRearing;
        }
        return null;
    }

    public function delete($id)
    {
        $chickRearing = ChickRearing::find($id);
        if ($chickRearing) {
            return $chickRearing->delete();
        }
        return false;
    }
}
