<?php

namespace App\Services;

use App\Repositories\Contracts\ScheduleRepositoryInterface;

class ScheduleService
{
    protected $scheduleRepository;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getAllSchedules(array $filters = [])
    {
        return $this->scheduleRepository->getAll($filters);
    }

    public function getScheduleById($id)
    {
        return $this->scheduleRepository->getById($id);
    }

    public function createSchedule(array $data)
    {
        return $this->scheduleRepository->create($data);
    }

    public function updateSchedule($id, array $data)
    {
        return $this->scheduleRepository->update($id, $data);
    }

    public function deleteSchedule($id)
    {
        return $this->scheduleRepository->delete($id);
    }
}
