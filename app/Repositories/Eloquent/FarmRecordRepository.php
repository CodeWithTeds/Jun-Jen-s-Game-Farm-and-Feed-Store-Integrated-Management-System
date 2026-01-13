<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\FarmRecordRepositoryInterface;
use App\Models\FarmRecord;
use Illuminate\Pagination\LengthAwarePaginator;

class FarmRecordRepository implements FarmRecordRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = FarmRecord::query()->with('recorder');

        if (isset($filters['search']) && $filters['search']) {
            $query->where(function($q) use ($filters) {
                $q->where('description', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('record_type', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('related_module', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['record_type']) && $filters['record_type']) {
            $query->where('record_type', $filters['record_type']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from']) && $filters['date_from']) {
            $query->whereDate('record_date', '>=', $filters['date_from']);
        }
        
        if (isset($filters['date_to']) && $filters['date_to']) {
            $query->whereDate('record_date', '<=', $filters['date_to']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id)
    {
        return FarmRecord::with('recorder')->find($id);
    }

    public function create(array $data)
    {
        return FarmRecord::create($data);
    }

    public function update($id, array $data)
    {
        $record = FarmRecord::find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function delete($id)
    {
        $record = FarmRecord::find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
}
