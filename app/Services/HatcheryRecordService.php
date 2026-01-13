<?php

namespace App\Services;

use App\Repositories\Contracts\HatcheryRecordRepositoryInterface;

class HatcheryRecordService
{
    protected $hatcheryRecordRepository;

    public function __construct(HatcheryRecordRepositoryInterface $hatcheryRecordRepository)
    {
        $this->hatcheryRecordRepository = $hatcheryRecordRepository;
    }

    public function getAllHatcheryRecords(array $filters = [])
    {
        return $this->hatcheryRecordRepository->getAll($filters);
    }

    public function getHatcheryRecordById($id)
    {
        return $this->hatcheryRecordRepository->getById($id);
    }

    public function createHatcheryRecord(array $data)
    {
        return $this->hatcheryRecordRepository->create($data);
    }

    public function updateHatcheryRecord($id, array $data)
    {
        return $this->hatcheryRecordRepository->update($id, $data);
    }

    public function deleteHatcheryRecord($id)
    {
        return $this->hatcheryRecordRepository->delete($id);
    }
    
    public function getByEggCollectionId($eggCollectionId)
    {
        return $this->hatcheryRecordRepository->getByEggCollectionId($eggCollectionId);
    }
}
