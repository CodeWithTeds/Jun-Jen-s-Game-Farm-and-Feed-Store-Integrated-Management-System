<?php

namespace App\Repositories\Eloquent;

use App\Models\FightSchedule;
use App\Repositories\Contracts\FightScheduleRepositoryInterface;

class FightScheduleRepository implements FightScheduleRepositoryInterface
{
    public function all()
    {
        return FightSchedule::with('gameFowl')->orderBy('date', 'desc')->get();
    }

    public function create(array $data)
    {
        return FightSchedule::create($data);
    }

    public function update(int $id, array $data)
    {
        $schedule = FightSchedule::find($id);
        if ($schedule) {
            $schedule->update($data);
            return $schedule;
        }
        return null;
    }

    public function delete(int $id)
    {
        return FightSchedule::destroy($id);
    }

    public function find(int $id)
    {
        return FightSchedule::with('gameFowl')->find($id);
    }

    public function getUpcoming()
    {
        return FightSchedule::with('gameFowl')
            ->where('status', 'Scheduled')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function getHistory()
    {
        return FightSchedule::with('gameFowl')
            ->whereIn('status', ['Completed', 'Cancelled'])
            ->orderBy('date', 'desc')
            ->get();
    }
}
