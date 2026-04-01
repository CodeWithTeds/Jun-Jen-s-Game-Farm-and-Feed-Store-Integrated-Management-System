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
        // New collections always start as Pending with 0 incubated
        $data['incubated_count'] = 0;
        $data['hatched_count']   = null;
        $data['failed_count']    = null;
        $data['incubation_status'] = 'Pending';

        return $this->eggCollectionRepository->create($data);
    }

    public function updateEggCollection($id, array $data)
    {
        // Auto-compute incubation_status based on counts
        $incubated = (int) ($data['incubated_count'] ?? 0);
        $hatched   = (int) ($data['hatched_count']   ?? 0);
        $failed    = (int) ($data['failed_count']    ?? 0);

        if ($incubated === 0) {
            $data['incubation_status'] = 'Pending';
        } elseif (($hatched + $failed) < $incubated) {
            $data['incubation_status'] = 'Incubating';
        } else {
            $data['incubation_status'] = 'Completed';
        }

        return $this->eggCollectionRepository->update($id, $data);
    }

    public function deleteEggCollection($id)
    {
        return $this->eggCollectionRepository->delete($id);
    }
}
