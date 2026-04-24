<?php

namespace App\Services;

use App\Repositories\Contracts\GameFowlRepositoryInterface;
use App\Repositories\Contracts\GameFowlInventoryRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GameFowlService
{
    protected $gameFowlRepository;
    protected $gameFowlInventoryRepository;

    public function __construct(
        GameFowlRepositoryInterface $gameFowlRepository,
        GameFowlInventoryRepositoryInterface $gameFowlInventoryRepository
    )
    {
        $this->gameFowlRepository = $gameFowlRepository;
        $this->gameFowlInventoryRepository = $gameFowlInventoryRepository;
    }

    public function getAllGameFowls(array $filters = [])
    {
        return $this->gameFowlRepository->getAll($filters);
    }

    public function getGameFowlById($id)
    {
        return $this->gameFowlRepository->getById($id);
    }

    public function createGameFowl(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('game-fowls', 'public');
        }

        $gameFowl = $this->gameFowlRepository->create($data);
        $this->syncInventoryAvailability($gameFowl->id, $data);

        return $gameFowl;
    }

    public function updateGameFowl($id, array $data)
    {
        $gameFowl = $this->gameFowlRepository->getById($id);

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image if exists
            if ($gameFowl->image) {
                Storage::disk('public')->delete($gameFowl->image);
            }
            $data['image'] = $data['image']->store('game-fowls', 'public');
        }

        $updated = $this->gameFowlRepository->update($id, $data);
        $this->syncInventoryAvailability($id, $data);

        return $updated;
    }

    public function deleteGameFowl($id)
    {
        $gameFowl = $this->gameFowlRepository->getById($id);

        if ($gameFowl->image) {
            Storage::disk('public')->delete($gameFowl->image);
        }

        return $this->gameFowlRepository->delete($id);
    }

    protected function syncInventoryAvailability(int $gameFowlId, array $data): void
    {
        if (($data['initial_health_status'] ?? null) === 'Dead') {
            $this->gameFowlInventoryRepository->markAsDeceasedByGameFowlId($gameFowlId);
        }
    }
}
