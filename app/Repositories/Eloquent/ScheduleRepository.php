<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ScheduleRepositoryInterface;
use App\Models\Schedule;
use Illuminate\Pagination\LengthAwarePaginator;

class ScheduleRepository implements ScheduleRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Schedule::query()->with('assignee');

        if (isset($filters['search']) && $filters['search']) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('schedule_type', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('related_module', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['schedule_type']) && $filters['schedule_type']) {
            $query->where('schedule_type', $filters['schedule_type']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['priority']) && $filters['priority']) {
            $query->where('priority', $filters['priority']);
        }

        if (isset($filters['date_from']) && $filters['date_from']) {
            $query->whereDate('start_date', '>=', $filters['date_from']);
        }
        
        if (isset($filters['date_to']) && $filters['date_to']) {
            $query->whereDate('start_date', '<=', $filters['date_to']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById($id)
    {
        return Schedule::with('assignee')->find($id);
    }

    public function create(array $data)
    {
        return Schedule::create($data);
    }

    public function update($id, array $data)
    {
        $schedule = Schedule::find($id);
        if ($schedule) {
            $schedule->update($data);
            return $schedule;
        }
        return null;
    }

    public function delete($id)
    {
        $schedule = Schedule::find($id);
        if ($schedule) {
            return $schedule->delete();
        }
        return false;
    }
}
