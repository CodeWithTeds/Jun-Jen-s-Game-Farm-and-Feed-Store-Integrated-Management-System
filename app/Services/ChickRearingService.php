<?php

namespace App\Services;

use App\Repositories\Contracts\ChickRearingRepositoryInterface;

class ChickRearingService
{
    protected $chickRearingRepository;

    public function __construct(ChickRearingRepositoryInterface $chickRearingRepository)
    {
        $this->chickRearingRepository = $chickRearingRepository;
    }

    public function getAllChickRearings(array $filters = [])
    {
        return $this->chickRearingRepository->getAll($filters);
    }

    public function getChickRearingById($id)
    {
        return $this->chickRearingRepository->getById($id);
    }

    public function createChickRearing(array $data)
    {
        return $this->chickRearingRepository->create($data);
    }

    public function updateChickRearing($id, array $data)
    {
        return $this->chickRearingRepository->update($id, $data);
    }

    public function deleteChickRearing($id)
    {
        return $this->chickRearingRepository->delete($id);
    }
}
