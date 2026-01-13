<?php

namespace App\Services;

use App\Repositories\Contracts\FarmRecordRepositoryInterface;

class FarmRecordService
{
    protected $farmRecordRepository;

    public function __construct(FarmRecordRepositoryInterface $farmRecordRepository)
    {
        $this->farmRecordRepository = $farmRecordRepository;
    }

    public function getAllRecords(array $filters = [])
    {
        return $this->farmRecordRepository->getAll($filters);
    }

    public function getRecordById($id)
    {
        return $this->farmRecordRepository->getById($id);
    }

    public function createRecord(array $data)
    {
        return $this->farmRecordRepository->create($data);
    }

    public function updateRecord($id, array $data)
    {
        return $this->farmRecordRepository->update($id, $data);
    }

    public function deleteRecord($id)
    {
        return $this->farmRecordRepository->delete($id);
    }
}
