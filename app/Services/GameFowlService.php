<?php

namespace App\Services;

use App\Repositories\Contracts\GameFowlRepositoryInterface;

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
        return $this->gameFowlRepository->create($data);
    }

    public function updateGameFowl($id, array $data)
    {
        return $this->gameFowlRepository->update($id, $data);
    }

    public function deleteGameFowl($id)
    {
        return $this->gameFowlRepository->delete($id);
    }
}
