<?php

namespace App\Services;

use App\Repositories\Contracts\FeedRepositoryInterface;

class FeedService
{
    protected $feedRepository;

    public function __construct(FeedRepositoryInterface $feedRepository)
    {
        $this->feedRepository = $feedRepository;
    }

    public function getAllFeeds(array $filters = [])
    {
        return $this->feedRepository->getAll($filters);
    }

    public function getFeedById($id)
    {
        return $this->feedRepository->getById($id);
    }

    public function createFeed(array $data)
    {
        return $this->feedRepository->create($data);
    }

    public function updateFeed($id, array $data)
    {
        return $this->feedRepository->update($id, $data);
    }

    public function deleteFeed($id)
    {
        return $this->feedRepository->delete($id);
    }
}
