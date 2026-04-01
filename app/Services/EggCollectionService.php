<?php

namespace App\Services;

use App\Repositories\Contracts\EggCollectionRepositoryInterface;
use Carbon\Carbon;

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
        $data['incubated_count']   = 0;
        $data['hatched_count']     = null;
        $data['failed_count']      = null;
        $data['incubation_status'] = 'Pending';

        return $this->eggCollectionRepository->create($data);
    }

    public function updateEggCollection($id, array $data)
    {
        $incubated = (int) ($data['incubated_count'] ?? 0);
        $hatched   = (int) ($data['hatched_count']   ?? 0);
        $failed    = (int) ($data['failed_count']    ?? 0);

        $expectedHatchDate = isset($data['expected_hatch_date']) && $data['expected_hatch_date']
            ? Carbon::parse($data['expected_hatch_date'])
            : null;

        $hatchDateReached = $expectedHatchDate && $expectedHatchDate->lte(Carbon::today());

        if ($hatchDateReached) {
            // Hatch date reached => force completion and assume everything hatched successfully if not explicitly provided
            $data['incubation_status'] = 'Completed';

            // Fall back to the original egg count if incubated wasn't specified yet
            $record = $this->eggCollectionRepository->getById($id);
            $totalCollected = (int) ($data['egg_count'] ?? $record->egg_count);

            if ($incubated === 0) {
                $incubated = $totalCollected;
                $data['incubated_count'] = $incubated;
            }

            // Auto-fill hatched_count with the remaining balance if they didn't manually sum it up
            if (($hatched + $failed) < $incubated) {
                $data['hatched_count'] = $incubated - $failed;
                $data['failed_count']  = $failed;
            }
        } elseif ($incubated === 0) {
            // Nothing placed in incubator yet
            $data['incubation_status'] = 'Pending';
        } elseif (($hatched + $failed) >= $incubated) {
            // All incubated eggs are accounted for manual completion
            $data['incubation_status'] = 'Completed';
        } else {
            // Eggs placed but results not yet complete and date not yet reached
            $data['incubation_status'] = 'Incubating';
        }

        return $this->eggCollectionRepository->update($id, $data);
    }

    public function deleteEggCollection($id)
    {
        return $this->eggCollectionRepository->delete($id);
    }
}
