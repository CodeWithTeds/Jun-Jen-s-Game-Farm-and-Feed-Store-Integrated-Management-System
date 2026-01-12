<?php

namespace App\Services;

use App\Repositories\Contracts\GameFowlRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GameFowlService
{
    protected $gameFowlRepository;

    public function __construct(GameFowlRepositoryInterface $gameFowlRepository)
    {
        $this->gameFowlRepository = $gameFowlRepository;
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

        return $this->gameFowlRepository->create($data);
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

        return $this->gameFowlRepository->update($id, $data);
    }

    public function deleteGameFowl($id)
    {
        $gameFowl = $this->gameFowlRepository->getById($id);

        if ($gameFowl->image) {
            Storage::disk('public')->delete($gameFowl->image);
        }

        return $this->gameFowlRepository->delete($id);
    }
}
