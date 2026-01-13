<?php

namespace App\Services;

use App\Repositories\Contracts\EggCollectionRepositoryInterface;

class EggCollectionService
{
    protected $eggCollectionRepository;

    public function __construct(EggCollectionRepositoryInterface $eggCollectionRepository)
    {
        $this->eggCollectionRepository = $eggCollectionRepository;
    }

    public function getAllEggCollections(array $filters = [])
    {
        return $this->eggCollectionRepository->getAll($filters);
    }

    public function getEggCollectionById($id)
    {
        return $this->eggCollectionRepository->getById($id);
    }

    public function createEggCollection(array $data)
    {
        return $this->eggCollectionRepository->create($data);
    }

    public function updateEggCollection($id, array $data)
    {
        return $this->eggCollectionRepository->update($id, $data);
    }

    public function deleteEggCollection($id)
    {
        return $this->eggCollectionRepository->delete($id);
    }
}
